<?php
declare(strict_types=1);

require_once __DIR__ . '/Tinta.php';

class TintaManager
{
    /**
     * @return Tinta[]
     */
    public static function getTintas(): array
    {
        return [
            new Tinta(
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
            new Tinta(
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
            new Tinta(
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
            new Tinta(
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
            new Tinta(
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
            new Tinta(
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
        ];
    }
}
