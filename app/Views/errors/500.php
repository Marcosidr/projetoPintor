<?php
http_response_code(500);
?><!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Erro Interno - CLPinturas</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh;">
  <div class="container text-center">
    <h1 class="display-4 text-danger mb-3">Erro 500</h1>
    <p class="lead mb-4">Ocorreu um erro inesperado. Nossa equipe será notificada.</p>
    <a href="<?= BASE_URL ?? '/' ?>" class="btn btn-success">Voltar para Home</a>
  </div>
</body>
</html>