<?php
/**
 * INYECTAR CSS DIRECTO EN LA PÁGINA
 * Solución de emergencia para forzar 2 columnas
 */

// Obtener el contenido de la página anuncios
$anuncios_url = 'http://mongruasformacion.local/anuncios/';

// Obtener el HTML de la página
$html = file_get_contents($anuncios_url);

if ($html) {
    // Inyectar CSS directamente en el HTML
    $css_injection = '
    <style id="forzar-2-columnas-emergency">
    /* EMERGENCIA - FORZAR 2 COLUMNAS */
    .courses-carousel,
    .courses-carousel-container,
    .carousel-controls,
    .carousel-btn,
    .carousel-indicators,
    .carousel-track,
    [class*="carousel"],
    [id*="carousel"] {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
    }
    
    .upcoming-courses-grid {
        display: grid !important;
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 30px !important;
        max-width: 900px !important;
        margin: 0 auto !important;
    }
    
    .upcoming-course-card {
        background: white !important;
        border-radius: 15px !important;
        padding: 25px !important;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
        transition: all 0.3s ease !important;
        border: 1px solid rgba(0,0,0,0.05) !important;
        position: relative !important;
    }
    
    .upcoming-course-card::before {
        content: "" !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        height: 4px !important;
        background: linear-gradient(90deg, #3498db, #27ae60) !important;
        border-radius: 15px 15px 0 0 !important;
    }
    
    @media (max-width: 768px) {
        .upcoming-courses-grid {
            grid-template-columns: 1fr !important;
        }
    }
    </style>
    
    <script>
    // FORZAR GRID AL CARGAR
    document.addEventListener("DOMContentLoaded", function() {
        // Eliminar carruseles
        const carousels = document.querySelectorAll("[class*=\"carousel\"], [id*=\"carousel\"]");
        carousels.forEach(el => el.remove());
        
        // Forzar grid
        const grids = document.querySelectorAll(".upcoming-courses-grid");
        grids.forEach(grid => {
            grid.style.display = "grid";
            grid.style.gridTemplateColumns = "repeat(2, 1fr)";
            grid.style.gap = "30px";
            grid.style.maxWidth = "900px";
            grid.style.margin = "0 auto";
        });
        
        console.log("✅ CSS de emergencia aplicado - 2 columnas forzadas");
    });
    </script>
    ';
    
    // Inyectar antes del </head>
    $html = str_replace('</head>', $css_injection . '</head>', $html);
    
    // Mostrar la página modificada
    echo $html;
} else {
    echo "<h1>Error: No se pudo cargar la página de anuncios</h1>";
    echo "<p>Verifica que la URL sea correcta: $anuncios_url</p>";
}
?>