document.addEventListener("DOMContentLoaded", function () {
    console.log("Reportes Index JS loaded");

    // Quick Export Handler (Placeholder for now)
    const exportButtons = document.querySelectorAll(".btn-quick-export");
    exportButtons.forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            // TODO: Implement quick export logic or show modal
            alert("Funcionalidad de exportación rápida en desarrollo");
        });
    });
});
