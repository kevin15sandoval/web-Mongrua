// FORM-VALIDATION.JS - LIMPIO SIN CARRUSEL
document.addEventListener("DOMContentLoaded", function() {
    console.log("✅ form-validation.js cargado - SIN funciones de carrusel");
    
    // FORZAR GRID DE 2 COLUMNAS
    function forceGrid() {
        const grids = document.querySelectorAll(".upcoming-courses-grid");
        grids.forEach(grid => {
            grid.style.display = "grid";
            grid.style.gridTemplateColumns = "repeat(2, 1fr)";
            grid.style.gap = "30px";
            grid.style.maxWidth = "900px";
            grid.style.margin = "0 auto";
        });
        
        // Eliminar cualquier carrusel
        const carousels = document.querySelectorAll("[class*=\"carousel\"], [id*=\"carousel\"]");
        carousels.forEach(el => {
            el.style.display = "none";
            el.style.visibility = "hidden";
            el.style.opacity = "0";
        });
    }
    
    // Aplicar inmediatamente
    forceGrid();
    
    // Aplicar cada 100ms durante 5 segundos para asegurar
    let counter = 0;
    const interval = setInterval(() => {
        forceGrid();
        counter++;
        if (counter > 50) { // 5 segundos
            clearInterval(interval);
        }
    }, 100);
    
    // Responsive
    window.addEventListener("resize", forceGrid);
});