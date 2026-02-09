/**
 * Upcoming Courses JavaScript - SOLO PARA PÁGINA DE ANUNCIOS
 * NO afecta la página de inicio
 */

document.addEventListener("DOMContentLoaded", function() {
    // Solo ejecutar en página de anuncios/cursos
    if (window.location.pathname.includes("anuncios") || 
        window.location.pathname.includes("cursos") ||
        document.body.classList.contains("page-template-page-cursos")) {
        
        console.log("🎓 Upcoming courses JS - Solo para página de anuncios");
        
        // Forzar grid de 2 columnas SOLO en página de anuncios
        function forceGridAnuncios() {
            const grids = document.querySelectorAll(".upcoming-courses-grid");
            grids.forEach(grid => {
                grid.style.display = "grid";
                grid.style.gridTemplateColumns = "repeat(2, 1fr)";
                grid.style.gap = "30px";
                grid.style.maxWidth = "900px";
                grid.style.margin = "0 auto";
            });
        }
        
        forceGridAnuncios();
        setInterval(forceGridAnuncios, 1000);
    } else {
        console.log("🏠 Página de inicio - NO aplicar cambios de anuncios");
    }
});