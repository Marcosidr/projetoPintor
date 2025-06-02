<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CL Pinturas - Quem Somos</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- AOS Animation -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>
<body>

<?php include("../header.php"); ?>

<div class="container my-5">
    <h1 class="mb-4">Quem Somos</h1>
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
<style>
    .card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
  
    
</style>
    <h2 class="mt-5">Nossos Valores</h2>
    <div class="row mt-4">
        <div class="col-md-4 mb-4" data-aos="fade-up">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                    <h5 class="card-title">Qualidade</h5>
                    <p class="card-text">Materiais de primeira linha e técnicas modernas.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-handshake fa-2x text-primary mb-3"></i>
                    <h5 class="card-title">Confiança</h5>
                    <p class="card-text">Relacionamento transparente e duradouro com o cliente.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-headset fa-2x text-warning mb-3"></i>
                    <h5 class="card-title">Excelência no Atendimento</h5>
                    <p class="card-text">Atendimento personalizado, com atenção aos detalhes.</p>
                </div>
            </div>
        </div>
    </div>

    

    <h2 class="mt-4">Nosso Compromisso</h2>
    <p>
        Cada projeto é uma nova história. Estamos comprometidos em transformar sonhos em realidade, oferecendo soluções de pintura que superam expectativas.
    </p>

    <h2 class="mt-4">Venha nos conhecer!</h2>
    <p>
        Convidamos você a fazer parte da nossa história. Entre em contato e veja como podemos transformar seu espaço com a arte da pintura.
        Aqui, cada pincelada é feita com amor e dedicação.
    </p>
 <?php include 'modal-orcamento.php'; ?>

  <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orcamentoModal">
    FAÇA SEU ORÇAMENTO
</a>

<?php include ("../footer.php") ?>


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();
</script>

</body>
</html>
