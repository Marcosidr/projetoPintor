<?php


// Parâmetro da URL para controle de página
$param = $_GET["param"] ?? "home";
$pagina = "páginas/{$param}.php";
?>
<body>
  
  <!-- Modal de Orçamento -->
<?php
 include 'páginas/modal-orcamento.php';
  ?>


  <!-- CONTEÚDO DA PÁGINA -->
  <div class="container my-5">
    <h1 class="text-center mb-4">Nossos Serviços</h1>
    <p class="text-center lead">
      Na CLPinturas, oferecemos uma vasta gama de serviços para atender todas as suas necessidades de pintura e acabamento.
      Nossa equipe especializada está pronta para transformar seu ambiente com qualidade e eficiência.
    </p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-5">
      <!-- Cards dos serviços -->
      <div class="col">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-success">Pintura Interna</h5>
            <p class="card-text">Transformamos seus ambientes internos com cores e texturas que refletem sua personalidade e estilo.</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-success">Pintura Externa</h5>
            <p class="card-text">Proteção e beleza para a fachada do seu imóvel, utilizando tintas resistentes às intempéries e técnicas avançadas.</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-success">Impermeabilização</h5>
            <p class="card-text">Soluções completas para proteger seu imóvel contra umidade, infiltrações e mofo, garantindo durabilidade e saúde.</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-success">Texturas e Grafiatos</h5>
            <p class="card-text">Adicione um toque de sofisticação e personalidade às suas paredes com uma variedade de texturas e grafiatos.</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-success">Restauração de Fachadas</h5>
            <p class="card-text">Recuperamos a beleza original de fachadas antigas, corrigindo imperfeições e aplicando acabamentos de alta qualidade.</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-success">Pintura Comercial</h5>
            <p class="card-text">Serviços de pintura para escritórios, lojas e outros espaços comerciais, minimizando interrupções e garantindo um resultado profissional.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center mt-5">
      <p class="lead">Precisa de um serviço específico que não está listado? Entre em contato conosco!</p>
      <a href="index.php?param=contato" class="btn btn-success btn-lg">Fale Conosco</a>
    
    </div>
  </div>


  <!-- Bootstrap script ao final -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
