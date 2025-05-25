<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CLPinturas - Contato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="/css/style.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-paint-green-700" href="index.php"><i class="bi bi-brush"></i> CLPINTURAS</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link text-paint-green-700 hover:text-paint-green-600" href="index.php">HOME</a></li>
                    <li class="nav-item"><a class="nav-link text-paint-green-700 hover:text-paint-green-600" href="index.php?page=quem-somos">QUEM SOMOS</a></li>
                    <li class="nav-item"><a class="nav-link text-paint-green-700 hover:text-paint-green-600" href="index.php?page=servicos">SERVIÇOS</a></li>
                    <li class="nav-item"><a class="nav-link text-paint-green-700 hover:text-paint-green-600" href="index.php?page=contato">CONTATO</a></li>
                    <li class="nav-item ms-2">
                        <a href="index.php?page=orcamento" class="btn btn-success rounded-full px-4 fw-bold text-white">
                            ORÇAMENTO
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    ```

---

<?php include('header.php'); ?>

<section class="relative py-20 bg-paint-cream-100">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-paint-green-700 mb-6">Entre em Contato</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">Estamos prontos para transformar seu projeto em realidade</p>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            <?php
            $contactInfo = [
                // Mapeando nomes de ícones Lucide para Bootstrap Icons
                ["icon_class" => "bi bi-geo-alt-fill", "title" => "Endereço", "info" => "Rua das Tintas, 123\nCentro, São Paulo - SP\nCEP: 01234-567"],
                ["icon_class" => "bi bi-phone-fill", "title" => "Telefone", "info" => "(11) 99999-9999\n(11) 3333-4444"],
                ["icon_class" => "bi bi-envelope-fill", "title" => "E-mail", "info" => "contato@clpinturas.com.br\norcamento@clpinturas.com.br"],
                ["icon_class" => "bi bi-clock-fill", "title" => "Horário de Atendimento", "info" => "Segunda a Sexta: 8h às 18h\nSábado: 8h às 12h\nDomingo: Fechado"]
            ];

            foreach ($contactInfo as $item) {
                echo '
                    <div class="text-center p-6 hover:shadow-lg transition-shadow duration-300 border rounded-2xl">
                        <div class="mb-4 flex justify-center">
                            <i class="' . $item["icon_class"] . ' h-8 w-8 text-paint-green-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">' . $item["title"] . '</h3>
                        <p class="text-gray-600 text-sm whitespace-pre-line">' . nl2br(htmlspecialchars($item["info"])) . '</p>
                    </div>
                ';
            }
            ?>
        </div>
    </div>
</section>

<section class="py-20 bg-paint-cream-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div>
                <h2 class="text-3xl font-bold text-paint-green-700 mb-6">Envie sua Mensagem</h2>
                <p class="text-gray-600 mb-8">Preencha o formulário abaixo que entraremos em contato o mais breve possível.</p>
                
                <form method="POST" action="enviar_contato.php" class="space-y-6 bg-white p-8 shadow rounded-xl">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                            <input type="text" id="nome" name="nome" required class="w-full border rounded-lg p-3" placeholder="Seu nome completo" />
                        </div>
                        <div>
                            <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">Telefone *</label>
                            <input type="tel" id="telefone" name="telefone" required class="w-full border rounded-lg p-3" placeholder="(11) 99999-9999" />
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mail *</label>
                        <input type="email" id="email" name="email" required class="w-full border rounded-lg p-3" placeholder="seu@email.com" />
                    </div>

                    <div>
                        <label for="assunto" class="block text-sm font-medium text-gray-700 mb-2">Assunto</label>
                        <input type="text" id="assunto" name="assunto" class="w-full border rounded-lg p-3" placeholder="Sobre o que você gostaria de falar?" />
                    </div>

                    <div>
                        <label for="mensagem" class="block text-sm font-medium text-gray-700 mb-2">Mensagem *</label>
                        <textarea id="mensagem" name="mensagem" rows="6" required class="w-full border rounded-lg p-3" placeholder="Conte-nos mais sobre seu projeto..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-paint-green-600 hover:bg-paint-green-700 text-white py-3 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                        <i class="bi bi-chat-dots-fill mr-2 h-5 w-5"></i> Enviar Mensagem
                    </button>
                </form>
            </div>

            <div>
                <h2 class="text-3xl font-bold text-paint-green-700 mb-6">Nossa Localização</h2>

                <div class="mb-8 bg-gray-200 rounded-lg flex items-center justify-center h-64 shadow">
                    <div class="text-center">
                        <i class="bi bi-map-fill h-12 w-12 text-gray-400 mb-2"></i>
                        <p class="text-gray-500">Mapa da localização</p>
                        <p class="text-sm text-gray-400">Rua das Tintas, 123 - Centro, São Paulo</p>
                    </div>
                </div>

                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Atendimento Personalizado</h3>
                    <div class="space-y-3 text-gray-600">
                        <p>• Visita técnica gratuita em toda a Grande São Paulo</p>
                        <p>• Orçamento detalhado sem compromisso</p>
                        <p>• Atendimento 24h para emergências</p>
                        <p>• Consultoria em cores e acabamentos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-paint-green-600 text-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Precisa de Atendimento Rápido?</h2>
        <p class="text-xl mb-8 opacity-90">Fale conosco pelo WhatsApp e tenha atendimento imediato</p>
        <a href="https://wa.me/seunumero" target="_blank" class="btn btn-light bg-white text-paint-green-600 hover:bg-gray-100 px-8 py-3 text-lg rounded-full transition-all duration-300 transform hover:scale-105">
            <i class="bi bi-whatsapp mr-2 h-5 w-5"></i> Chamar no WhatsApp
        </a>
    </div>
</section>

<?php include('footer.php'); ?>