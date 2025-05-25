
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Serviços | CLPinturas</title>
  <link rel="stylesheet" href="css/servicos.css" />
</head>
<body>

  <?php include 'components/header.php'; ?>

  <!-- Hero -->
  <section class="hero">
    <h1>Nossos Serviços</h1>
    <p>Soluções completas em pintura para todos os tipos de projeto</p>
  </section>

  <!-- Principais Serviços -->
  <section class="servicos">
    <h2>Principais Serviços</h2>
    <p class="subtitulo">Oferecemos uma gama completa de serviços de pintura com qualidade profissional</p>

    <div class="cards">
      <?php
        $servicos = [
          [
            "titulo" => "Pinturas Gerais",
            "descricao" => "Pintura residencial e comercial com acabamento impecável",
            "itens" => [
              "Pintura interna e externa",
              "Preparação completa da superfície",
              "Tintas de alta qualidade",
              "Acabamento profissional"
            ]
          ],
          [
            "titulo" => "Pinturas Versáteis",
            "descricao" => "Técnicas especiais para ambientes únicos e personalizados",
            "itens" => [
              "Técnicas decorativas",
              "Efeitos especiais",
              "Cores personalizadas",
              "Consultoria em design"
            ]
          ],
          [
            "titulo" => "Tratamento de Superfícies",
            "descricao" => "Preparação especializada para maior durabilidade",
            "itens" => [
              "Lixamento e preparação",
              "Correção de imperfeições",
              "Aplicação de primers",
              "Seladores especiais"
            ]
          ],
          [
            "titulo" => "Pintura Comercial",
            "descricao" => "Projetos corporativos com prazos e qualidade garantidos",
            "itens" => [
              "Grandes áreas",
              "Prazos otimizados",
              "Trabalho noturno/finais de semana",
              "Mínimo impacto nas atividades"
            ]
          ],
          [
            "titulo" => "Impermeabilização",
            "descricao" => "Proteção definitiva contra umidade e infiltrações",
            "itens" => [
              "Sistemas impermeabilizantes",
              "Tratamento de lajes",
              "Proteção de fachadas",
              "Garantia estendida"
            ]
          ],
          [
            "titulo" => "Revestimentos e Texturas",
            "descricao" => "Acabamentos especiais para valorizar seu espaço",
            "itens" => [
              "Texturas decorativas",
              "Revestimentos especiais",
              "Grafiatos e relevos",
              "Acabamentos rústicos"
            ]
          ]
        ];

        foreach ($servicos as $servico) {
          echo '<div class="card">';
          echo "<h3>{$servico['titulo']}</h3>";
          echo "<p>{$servico['descricao']}</p>";
          echo '<ul>';
          foreach ($servico['itens'] as $item) {
            echo "<li>✔️ $item</li>";
          }
          echo '</ul>';
          echo '</div>';
        }
      ?>
    </div>
  </section>

  <!-- Processo -->
  <section class="processo">
    <h2>Nosso Processo</h2>
    <p class="subtitulo">Metodologia comprovada para garantir qualidade e satisfação</p>

    <div class="etapas">
      <?php
        $etapas = [
          ["01", "Avaliação Técnica", "Visita técnica gratuita para análise detalhada do projeto"],
          ["02", "Orçamento Detalhado", "Proposta completa com materiais e prazos"],
          ["03", "Preparação", "Proteção do ambiente e preparação da superfície"],
          ["04", "Execução", "Aplicação profissional com técnicas modernas"],
          ["05", "Entrega", "Limpeza e entrega com garantia de qualidade"]
        ];

        foreach ($etapas as $etapa) {
          echo '<div class="etapa">';
          echo "<div class='numero'>{$etapa[0]}</div>";
          echo "<h4>{$etapa[1]}</h4>";
          echo "<p>{$etapa[2]}</p>";
          echo '</div>';
        }
      ?>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta">
    <h2>Pronto para Transformar seu Espaço?</h2>
    <p>Entre em contato e receba um orçamento personalizado sem compromisso</p>
    <div class="botoes">
      <a href="orcamento.php" class="btn">Solicitar Orçamento</a>
      <a href="contato.php" class="btn btn-outline">Falar Conosco</a>
    </div>
  </section>

  <?php include 'components/footer.php'; ?>

</body>
</html>
