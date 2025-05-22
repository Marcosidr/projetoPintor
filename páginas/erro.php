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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $page_description; ?>">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="css/main.css">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>
    
    <!-- Error Section -->
    <section class="error-section">
      <div class="container">
        <div class="error-content">
          <h1>Erro <?php echo $error_code; ?></h1>
          <h2><?php echo $error_message; ?></h2>
          <p>Desculpe, mas a página que você está procurando não foi encontrada.</p>
          <div class="error-actions">
            <a href="index.php" class="btn btn-primary">Voltar para a Página Inicial</a>
            <a href="contato.php" class="btn btn-secondary">Entrar em Contato</a>
          </div>
        </div>
      </div>
    </section>
    
    <?php include 'includes/footer.php'; ?>
    
    <script src="js/main.js"></script>
</body>
</html>
