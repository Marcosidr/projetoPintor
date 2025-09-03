<?php


// Parâmetro da URL para controle de página
$param = $_GET["param"] ?? "home";
$pagina = "páginas/{$param}.php";
?>
  <!-- Modal de Orçamento -->
<?php
 include 'páginas/modal-orcamento.php';
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">



  <link rel="stylesheet" href="css/quem-somos.css">
  
  <title>QUEM SOMOS</title>
</head>
<body>
  
</body>
</html>
  <div class="container py-5">
    <h1 class="mb-4 text-center" data-aos="fade-down">Quem Somos</h1>

    <div class="mb-5" data-aos="fade-right">
<p>
  A <strong><span style="color: #27662a;">CLPinturas</span></strong> nasceu do sonho de transformar ambientes comuns em espaços únicos e cheios de vida, através da arte da pintura.
  Fundada como uma pequena empresa familiar, trilhamos um caminho de crescimento sólido, sempre guiados por três pilares:
  <strong><span style="color: #27662a;">qualidade</span></strong>, 
  <strong><span style="color: #27662a;">confiança</span></strong> e 
  <strong><span style="color: #27662a;">excelência no atendimento</span></strong>.
</p>

      <p>
        Nossa história é construída com dedicação e trabalho honesto. Ao longo dos anos, realizamos milhares de projetos — de lares acolhedores
        a grandes empreendimentos comerciais — sempre com o compromisso de superar expectativas.
      </p>
      <p>
        Hoje, a CLPinturas é referência no mercado, reconhecida pela qualidade dos serviços, pontualidade e profissionalismo de sua equipe.
        Transformar espaços é mais do que um trabalho — é nossa missão.
      </p>
    </div>

 <!-- Seção Nossos Valores -->
<section class="bg-paint-cream-50 py-5">
  <div class="container">
    <h2 class="text-center text-paint-green-700 fw-bold mb-2">Nossos Valores</h2>
    <p class="text-center text-muted mb-5">
      Os princípios que norteiam cada projeto e nos mantêm como referência no mercado
    </p>

    <div class="row text-center g-4">
      <!-- Qualidade -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card p-4 shadow-sm h-100 rounded-4">
          <i class="fas fa-bullseye fa-2x text-paint-green-700 mb-3"></i>
          <h5 class="fw-bold text-dark">Qualidade</h5>
          <p class="text-muted mb-0">
            Compromisso com a excelência em cada projeto realizado
          </p>
        </div>
      </div>

      <!-- Confiança -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card p-4 shadow-sm h-100 rounded-4">
          <i class="fas fa-user-friends fa-2x text-paint-green-700 mb-3"></i>
          <h5 class="fw-bold text-dark">Confiança</h5>
          <p class="text-muted mb-0">
            Relacionamentos duradouros baseados na transparência
          </p>
        </div>
      </div>

      <!-- Experiência -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card p-4 shadow-sm h-100 rounded-4">
          <i class="fas fa-award fa-2x text-paint-green-700 mb-3"></i>
          <h5 class="fw-bold text-dark">Experiência</h5>
          <p class="text-muted mb-0">
            Mais de 25 anos de conhecimento e aperfeiçoamento
          </p>
        </div>
      </div>

      <!-- Pontualidade -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card p-4 shadow-sm h-100 rounded-4">
          <i class="fas fa-clock fa-2x text-paint-green-700 mb-3"></i>
          <h5 class="fw-bold text-dark">Pontualidade</h5>
          <p class="text-muted mb-0">
            Cumprimento rigoroso de prazos estabelecidos
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

    <div class="mt-5" data-aos="fade-left">
      <h2>Nosso Compromisso</h2>
      <p>
     Estamos aqui para transformar suas ideias em realidade com pintura de qualidade, feita por profissionais experientes.

Usamos materiais certificados e técnicas adequadas para garantir um acabamento duradouro e que realmente valorize seu espaço. Não prometemos milagres, mas trabalho sério, cumprimento de prazos e preço justo.

Nosso compromisso é entregar o serviço bem feito, respeitando seu tempo e investimento. Se busca resultado de verdade, com transparência e sem complicação, estamos prontos para começar.
      </p>
    </div>

    <div class="mt-4" data-aos="fade-up">
      <h2>Venha nos conhecer!</h2>
      
    </div>
<div class="text-center mt-5" data-aos="zoom-in-up">
  <iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3661.926397388448!2d-52.7890005!3d-24.2442766!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ed7653f829ca69%3A0x51c188b2fdc8de58!2sBoa%20Esperan%C3%A7a%2C%20PR!5e0!3m2!1spt-BR!2sbr!4v1717808300000!5m2!1spt-BR!2sbr" 
    width="100%" 
    height="400" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade">
  </iframe>
</div>


  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

</body>
</html>