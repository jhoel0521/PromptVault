document.addEventListener("DOMContentLoaded", function () {
    // Select All functionality per module
    const selectAllBtns = document.querySelectorAll(".select-all-btn");

    selectAllBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
            const moduleCard = this.closest(".module-card");
            const checkboxes = moduleCard.querySelectorAll(
                ".permission-checkbox"
            );

            // Check if all are currently checked to determine toggle state
            let allChecked = true;
            checkboxes.forEach((cb) => {
                if (!cb.checked) allChecked = false;
            });

            // Toggle logic
            checkboxes.forEach((cb) => {
                cb.checked = !allChecked;
            });

            // Update button text
            this.textContent = allChecked
                ? "Seleccionar Todo"
                : "Deseleccionar Todo";
        });
    });
});
