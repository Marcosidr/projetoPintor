<?php
// Front Controller
define('ROOT_PATH', dirname(__DIR__) . '/');

// Força exibição de erros em ambiente de diagnóstico.
// ATENÇÃO: Remover (ou definir APP_DEBUG=false) em produção.
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require ROOT_PATH.'vendor/autoload.php';

// Carrega variáveis de ambiente antes de decidir debug
if (class_exists(\App\Core\Env::class)) {
	\App\Core\Env::load(ROOT_PATH.'.env');
}

// Config de ambiente básico após carregar .env
// Mantém controle por APP_DEBUG, mas já ativamos acima para sessão atual.
if (getenv('APP_DEBUG') !== 'true') {
	// Se quiser que debug respeite .env, comente as três linhas de ini_set acima.
	ini_set('display_errors', '0');
}

// Handler simples para exceções não tratadas
set_exception_handler(function(Throwable $e){
	http_response_code(500);
	if (getenv('APP_DEBUG') === 'true') {
		echo '<pre style="padding:1rem;font:14px monospace;">'.htmlspecialchars($e).'</pre>';
	} else {
		if (is_file(ROOT_PATH.'app/Views/errors/500.php')) { require ROOT_PATH.'app/Views/errors/500.php'; }
		else echo 'Erro interno';
	}
	// TODO: opcional: enviar para LoggerService
});

// Handler para erros fatais convertendo em página 500
register_shutdown_function(function(){
	$err = error_get_last();
	if ($err && in_array($err['type'], [E_ERROR,E_PARSE,E_CORE_ERROR,E_COMPILE_ERROR])) {
		http_response_code(500);
		if (getenv('APP_DEBUG') === 'true') {
			echo '<pre style="padding:1rem;font:14px monospace;">FATAL: '.htmlspecialchars($err['message'])."\n".$err['file'].':'.$err['line'].'</pre>';
		} else {
			if (is_file(ROOT_PATH.'app/Views/errors/500.php')) { require ROOT_PATH.'app/Views/errors/500.php'; }
			else echo 'Erro interno';
		}
	}
});

try {
	require ROOT_PATH.'bootstrap/app.php';
} catch (Throwable $e) {
	throw $e; // delegado ao handler global
}
