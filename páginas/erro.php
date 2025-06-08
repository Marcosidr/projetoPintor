<?php 
$page_title = "Erro - CL Pinturas";
$page_description = "Página não encontrada";
$error_code = $_GET['code'] ?? '404';
$error_message = 'Página não encontrada';

switch($error_code) {
    case '403':
        $error_message = 'Acesso proibido';
        break;
    case '500':
        $error_message = 'Erro interno do servidor';
        break;
    default:
        $error_message = 'Página não encontrada';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $page_description; ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- CSS Files -->
    <link rel="stylesheet" href="css/main.css" />
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <style>
        body {
            background-color: #f5f5dc;
            font-family: Arial, sans-serif;
        }
        
        .error-section {
            text-align: center;
            padding: 100px 20px;
        }
        
        .error-section h1 {
            font-size: 72px;
            color: #dc3545;
        }
        
        .error-section h2 {
            font-size: 36px;
            color: #343a40;
        }
        
        .error-section p {
            font-size: 18px;
            color: #6c757d;
        }
        
        .error-actions {
            margin-top: 30px;
        }
        
        /* Botões verdes personalizados */
        .btn-verde {
            background-color: #27652b;
            border: none;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }
        
        .btn-verde:hover {
            background-color: #1e4f22;
        }
       
        /* Espaçamento entre botões */
        .error-actions a + a {
            margin-left: 15px;
        }
    </style>
</head>
<body>
   
    
    <!-- Error Section -->
    <section class="error-section">
        <div class="container">
            <div class="error-content">
                <h1>Erro <?php echo htmlspecialchars($error_code); ?></h1>
                <h2><?php echo htmlspecialchars($error_message); ?></h2>
                <p>Desculpe, mas a página que você está procurando não foi encontrada.</p>
                <div class="error-actions">
                    <a href="../index.php" class="btn-verde">Voltar para a Página Inicial</a>
                    <a href="páginas/contato.php" class="btn-verde">Entrar em Contato</a>
                </div>
            </div>
        </div>
    </section>
    
    <script src="js/main.js"></script>
</body>
</html>
