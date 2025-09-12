<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Repositories\DbLogRepository;
use App\Services\LoggerService;

class LogController extends Controller
{
    public function index(): void
    {
        Auth::requireAdmin();

        $filtroAcao = trim($_GET['acao'] ?? '');
        $filtroData = trim($_GET['data'] ?? date('Y-m-d'));
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $filtroData)) {
            $filtroData = date('Y-m-d');
        }
        $page = (int)($_GET['page'] ?? 1); if ($page < 1) $page = 1;
        $perPage = 20;

        $driver = getenv('LOG_DRIVER') ?: 'file';
        if ($driver === 'db') {
            $repo = new DbLogRepository();
            $result = $repo->paginate(['acao'=>$filtroAcao,'data'=>$filtroData], $page, $perPage);
            $logs = array_map(function($r){
                return [
                    'datahora' => $r['ts'] ?? null,
                    'usuario' => $r['user_id'] ?? null,
                    'acao' => $r['acao'] ?? '',
                    'nivel' => 'INFO',
                    'detalhes' => isset($r['ctx']) ? json_encode($r['ctx'], JSON_UNESCAPED_UNICODE) : ''
                ];
            }, $result['data']);
            $paginacao = [
                'page' => $result['page'],
                'totalPages' => $result['totalPages'],
                'total' => $result['total'],
                'perPage' => $result['perPage'],
            ];
        } else {
            $allLogs = $this->readByDate($filtroData);
            if ($filtroAcao !== '') {
                $allLogs = array_values(array_filter($allLogs, function($l) use ($filtroAcao){
                    return stripos($l['acao'] ?? '', $filtroAcao) !== false;
                }));
            }
            $total = count($allLogs);
            $totalPages = max(1, (int)ceil($total / $perPage));
            if ($page > $totalPages) $page = $totalPages;
            $offset = ($page - 1) * $perPage;
            $logs = array_slice($allLogs, $offset, $perPage);
            $paginacao = [
                'page' => $page,
                'totalPages' => $totalPages,
                'total' => $total,
                'perPage' => $perPage,
            ];
        }

        $this->view('painel/logs', compact('logs','filtroAcao','filtroData','paginacao'));
    }
    
        // Endpoint opcional para ingestão externa de log (ex: fetch POST /log)
        // Espera campos: acao (string), ctx (json opcional)
        public function store(): void {
                // Autorização: admin logado OU header X-Log-Token válido
                $tokenHeader = $_SERVER['HTTP_X_LOG_TOKEN'] ?? '';
                $envToken = getenv('LOG_INGEST_TOKEN');
                $hasValidToken = $envToken && hash_equals($envToken, $tokenHeader);
                $isAdmin = Auth::checkAdmin();

                $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
                if (!$this->rateLimitAllow($ip)) {
                    http_response_code(429); header('Content-Type: application/json'); echo json_encode(['ok'=>false,'error'=>'rate_limited']); return; }

                if (!$hasValidToken && !$isAdmin) {
                    // Loga tentativa 401 simplificada
                    (new LoggerService())->info(null, 'log_ingest_unauthorized', ['ip'=>$ip,'ua'=>$_SERVER['HTTP_USER_AGENT'] ?? null]);
                    http_response_code(401); header('Content-Type: application/json'); echo json_encode(['ok'=>false,'error'=>'unauthorized']); return; }

                $acao = $_POST['acao'] ?? '';
                $acao = trim($acao);
                if ($acao === '' || strlen($acao) > 120) { http_response_code(422); echo 'acao inválida'; return; }

                $ctxRaw = $_POST['ctx'] ?? '';
                $ctx = [];
                if ($ctxRaw !== '') {
                    $tmp = json_decode($ctxRaw, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($tmp)) { $ctx = $tmp; }
                }
                // Limita tamanho serializado do contexto (2KB)
                $encoded = json_encode($ctx, JSON_UNESCAPED_UNICODE);
                if (strlen($encoded) > 2048) {
                    $ctx = ['_truncated'=>true];
                }

                (new LoggerService())->info(\App\Core\Session::get('usuario')['id'] ?? null, $acao, $ctx + ['via'=>$hasValidToken ? 'token':'admin']);
                header('Content-Type: application/json'); echo json_encode(['ok'=>true]);
        }

    private function readByDate(string $date): array {
        $file = ROOT_PATH . 'storage/logs/app-' . $date . '.log';
        if (!is_file($file)) return [];
        $rows = [];
        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $decoded = json_decode($line, true);
            if (!is_array($decoded)) continue;
            // Normaliza para estrutura da view
            $rows[] = [
                'datahora' => $decoded['ts'] ?? null,
                'usuario' => $decoded['user'] ?? null,
                'acao' => $decoded['acao'] ?? '',
                'nivel' => 'INFO',
                'detalhes' => isset($decoded['ctx']) ? json_encode($decoded['ctx'], JSON_UNESCAPED_UNICODE) : '',
            ];
        }
        return array_reverse($rows); // mais recente primeiro
    }

    // Rate limit simples em memória de processo (reset a cada request no PHP FPM/Apache). Para algo mais robusto: Redis ou tabela.
    private array $rateHits = [];
    private function rateLimitAllow(string $ip): bool {
        $now = time();
        $window = 60; // 60s
        $max = 60; // 60 requisições/min
        // Limpa entradas antigas
        foreach ($this->rateHits as $k=>$arr) { if ($arr['ts'] < $now - $window) unset($this->rateHits[$k]); }
        if (!isset($this->rateHits[$ip])) { $this->rateHits[$ip] = ['count'=>0,'ts'=>$now]; }
        if ($this->rateHits[$ip]['ts'] < $now - $window) { $this->rateHits[$ip] = ['count'=>0,'ts'=>$now]; }
        if ($this->rateHits[$ip]['count'] >= $max) return false;
        $this->rateHits[$ip]['count']++;
        return true;
    }
}
