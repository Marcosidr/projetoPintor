<?php
namespace App\Core;

/**
 * Classe base para todos os Controllers.
 * Responsabilidades principais:
 *  - Fornecer método view() que encapsula a captura do conteúdo da view e injeta no layout principal.
 *  - Disponibilizar redirect() simples para evitar repetição de header/exit.
 *
 * Decisões:
 *  - Uso de extract($data) para tornar variáveis acessíveis diretamente na view (trade-off: requer cuidado para não sobrescrever nomes).
 *  - Buffer de saída (ob_start) permite montar o conteúdo antes de incluir layout.
 */
abstract class Controller {
    /** Renderiza uma view dentro do layout principal.
     * @param string $path Caminho relativo dentro de app/Views (ex: 'home/index')
     * @param array $data  Dados a serem extraídos como variáveis locais na view
     */
    protected function view(string $path, array $data = []): void {
        extract($data); // Torna chaves de $data variáveis disponíveis na view
        ob_start();
        require ROOT_PATH.'app/Views/'.$path.'.php'; // Renderiza a view específica
        $content = ob_get_clean(); // Captura e limpa buffer -> variável usada no layout
        require ROOT_PATH.'app/Views/layouts/main.php'; // Layout usa $content para injetar estrutura comum
    }

    /** Redireciona para rota relativa à BASE_URL e encerra execução */
    protected function redirect(string $to): void {
        header('Location: '.BASE_URL.$to);
        exit;
    }
}
