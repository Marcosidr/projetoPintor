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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <link rel="stylesheet" href="css/quem-somos.css">
  <title>QUEM SOMOS</title>
</head>
<body>
  
</body>
</html>l
  <div class="container py-5">
    <h1 class="mb-4 text-center" data-aos="fade-down">Quem Somos</h1>

    <div class="mb-5" data-aos="fade-right">
      <p>
        A <strong>CLPinturas</strong> nasceu do sonho de transformar ambientes comuns em espaços únicos e cheios de vida, através da arte da pintura.
        Fundada como uma pequena empresa familiar, trilhamos um caminho de crescimento sólido, sempre guiados por três pilares:
        <strong>qualidade</strong>, <strong>confiança</strong> e <strong>excelência no atendimento</strong>.
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

    <h2 class="mb-4 text-center" data-aos="fade-up">Nossos Valores</h2>
    <div class="row text-center">
      <div class="col-md-4 mb-4" data-aos="zoom-in">
        <div class="card p-4 shadow-sm h-100">
          <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
          <h5>Qualidade</h5>
          <p>Materiais de primeira linha e técnicas modernas.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="100">
        <div class="card p-4 shadow-sm h-100">
          <i class="fas fa-handshake fa-2x text-primary mb-3"></i>
          <h5>Confiança</h5>
          <p>Relacionamento transparente e duradouro com o cliente.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="200">
        <div class="card p-4 shadow-sm h-100">
          <i class="fas fa-headset fa-2x text-warning mb-3"></i>
          <h5>Excelência no Atendimento</h5>
          <p>Atendimento personalizado, com atenção aos detalhes.</p>
        </div>
      </div>
    </div>

    <div class="mt-5" data-aos="fade-left">
      <h2>Nosso Compromisso</h2>
      <p>
        Cada projeto é uma nova história. Estamos comprometidos em transformar sonhos em realidade,
        oferecendo soluções de pintura que superam expectativas.
      </p>
    </div>

    <div class="mt-4" data-aos="fade-up">
      <h2>Venha nos conhecer!</h2>
      <p>
        Convidamos você a fazer parte da nossa história. Entre em contato e veja como podemos transformar seu espaço com a arte da pintura.
        Aqui, cada pincelada é feita com amor e dedicação.
      </p>
    </div>

    <div class="text-center mt-5" data-aos="zoom-in-up">
      <a href="#" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#orcamentoModal">
        FAÇA SEU ORÇAMENTO
      </a>
    </div>
  </div>

 <?php include 'páginas/modal-orcamento.php'; ?>
 

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

</body>
</html>
