<?php
require_once __DIR__ . '/Servico.php';

class ServicoManager
{
    /**
     * Retorna a lista de serviços disponíveis
     * @return Servico[]
     */
    public static function getServicos(): array
    {
        return [
            new Servico(
                "bi bi-house-door",
                "Pintura Residencial",
                "Transforme sua casa com cores vibrantes e acabamento perfeito.",
                ["Paredes internas e externas", "Acabamento premium", "Consultoria de cores"]
            ),
            new Servico(
                "bi bi-building",
                "Pintura Comercial",
                "Destaque sua empresa com um ambiente renovado e acolhedor.",
                ["Salas e escritórios", "Fachadas comerciais", "Rapidez na execução"]
            ),
            new Servico(
                "bi bi-brush",
                "Textura e Grafiato",
                "Acabamentos modernos e diferenciados para valorizar seu espaço.",
                ["Textura acrílica", "Grafiato resistente", "Aplicação profissional"]
            ),
            new Servico(
                "bi bi-droplet-half",
                "Impermeabilização",
                "Proteja seu imóvel contra infiltrações e umidade.",
                ["Áreas externas", "Lajes e telhados", "Produtos de alta durabilidade"]
            ),
            new Servico(
                "bi bi-tools",
                "Restauração",
                "Recupere paredes e superfícies danificadas com qualidade.",
                ["Correção de trincas", "Massa corrida e nivelamento", "Repintura completa"]
            ),
            new Servico(
                "bi bi-bricks",
                "Acabamentos Especiais",
                "Serviços exclusivos que trazem sofisticação ao seu ambiente.",
                ["Efeitos decorativos", "Cimento queimado", "Revestimentos criativos"]
            ),
            // 👇 novos serviços adicionados
            new Servico(
                "bi bi-lightning-charge",
                "Pintura Eletrostática",
                "Acabamento durável e uniforme para metais e superfícies industriais.",
                ["Estruturas metálicas", "Portões e grades", "Cabines especializadas"]
            ),
            new Servico(
                "bi bi-tree",
                "Pintura Ecológica",
                "Utilizamos tintas sustentáveis que respeitam o meio ambiente.",
                ["Tintas à base de água", "Baixo odor", "Certificação ambiental"]
            ),
            new Servico(
                "bi bi-sun",
                "Tratamento Antimofo e Antiumidade",
                "Elimine manchas e bolores garantindo a saúde da sua família.",
                ["Produtos fungicidas", "Ambientes úmidos", "Prevenção de infiltrações"]
            ),
            new Servico(
                "bi bi-palette",
                "Design de Ambientes",
                "Auxílio na escolha de cores e texturas para harmonizar seu espaço.",
                ["Consultoria personalizada", "Tendências atuais", "Paleta de cores"]
            ),
            new Servico(
                "bi bi-building-fill",
                "Pintura Industrial",
                "Serviços especializados para indústrias e galpões.",
                ["Pisos industriais", "Sinalização de segurança", "Revestimentos protetivos"]
            ),
            new Servico(
                "bi bi-door-open",
                "Pintura de Portas e Janelas",
                "Renove portas e esquadrias com acabamentos modernos.",
                ["Madeira e metal", "Laqueação", "Durabilidade garantida"]
            )
        ];
    }
}
