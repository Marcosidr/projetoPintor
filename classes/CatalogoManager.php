<?php
declare(strict_types=1);

require_once __DIR__ . '/Catalogo.php';

class CatalogoManager
{
    /**
     * @return CatalogoItem[]
     */
    public static function getItens(): array
    {
        return [
            new CatalogoItem(
                "bi bi-brush text-primary",
                "Tinta Látex (PVA)",
                "",
                [
                    "Acabamento fosco suave",
                    "Fácil de limpar durante a aplicação",
                    "Custo acessível",
                    "Rendimento elevado",
                    "Secagem rápida (cerca de 30 minutos ao toque)"
                ],
                "#e3f2fd"
            ),
            new CatalogoItem(
                "bi bi-droplet-half text-success",
                "Tinta Acrílica",
                "",
                [
                    "Alta resistência à água e intempéries",
                    "Fácil manutenção e limpeza",
                    "Odor suave",
                    "Secagem rápida",
                    "Disponível em várias cores e acabamentos"
                ],
                "#e8f5e9"
            ),
            new CatalogoItem(
                "bi bi-palette text-warning",
                "Esmalte Sintético",
                "",
                [
                    "Alta durabilidade e proteção",
                    "Resistente a riscos e impactos",
                    "Acabamento liso e uniforme",
                    "Ideal para ambientes internos e externos",
                    "Disponível em diversas cores"
                ],
                "#fff3e0"
            ),
            new CatalogoItem(
                "bi bi-box-seam text-secondary",
                "Tinta Epóxi",
                "",
                [
                    "Altíssima resistência química e abrasiva",
                    "Impermeável",
                    "Ideal para áreas de alto tráfego",
                    "Pode ser aplicada em pisos, paredes e azulejos",
                    "Acabamento brilhante ou acetinado"
                ],
                "#eceff1"
            ),
            new CatalogoItem(
                "bi bi-lightning-charge text-danger",
                "Spray / Grafite",
                "",
                [
                    "Aplicação rápida e prática",
                    "Secagem quase instantânea",
                    "Ideal para detalhes e arte urbana",
                    "Grande variedade de cores e efeitos",
                    "Pode ser usada em metal, plástico, madeira e vidro"
                ],
                "#fce4ec"
            ),
            new CatalogoItem(
                "bi bi-texture text-success",
                "Texturizada",
                "",
                [
                    "Efeito decorativo e moderno",
                    "Disfarça imperfeições da parede",
                    "Alta resistência a intempéries",
                    "Ideal para fachadas e paredes de destaque",
                    "Pode ser pintada posteriormente"
                ],
                "#f9fbe7"
            ),
            new CatalogoItem(
                "bi bi-droplet text-info",
                "Tinta Acrílica Premium",
                "",
                [
                    "Acabamento superior e duradouro",
                    "Resistência a manchas e sujeira",
                    "Fácil aplicação e acabamento",
                    "Secagem rápida",
                    "Disponível em diversas cores"
                ],
                "#e1f5fe"
            ),
            new CatalogoItem(
                "bi bi-shield-check text-primary",
                "Tinta Antimofo e Antiumidade",
                "",
                [
                    "Previne o aparecimento de mofo e bolor",
                    "Resistente à umidade",
                    "Ideal para áreas internas e externas",
                    "Fácil aplicação e limpeza",
                    "Disponível em diversas cores"
                ],
                "#e0f7fa"
            ),
            new CatalogoItem(
                "bi bi-paint-bucket text-secondary",
                "Tinta para Piso",
                "",
                [
                    "Alta resistência ao tráfego",
                    "Fácil aplicação e limpeza",
                    "Secagem rápida",
                    "Disponível em diversas cores"
                ],
                "#f5f5f5"
            )
        ];
    }
}
