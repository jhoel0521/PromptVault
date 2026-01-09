document.addEventListener("DOMContentLoaded", function () {
    // Search functionality with debounce
    const searchInput = document.getElementById("searchInput");
    let timeoutId;

    if (searchInput) {
        searchInput.addEventListener("input", function (e) {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                updateQueryParam("search", e.target.value);
            }, 500);
        });
    }

    // Filter by Type
    const typeSelect = document.getElementById("typeSelect");
    if (typeSelect) {
        typeSelect.addEventListener("change", function (e) {
            updateQueryParam("tipo", e.target.value);
        });
    }

    // Per Page Selection
    const entriesSelect = document.getElementById("entriesSelect");
    if (entriesSelect) {
        entriesSelect.addEventListener("change", function (e) {
            updateQueryParam("per_page", e.target.value);
        });
    }

    // Helper function to update URL parameters
    function updateQueryParam(key, value) {
        const url = new URL(window.location.href);
        if (value) {
            url.searchParams.set(key, value);
        } else {
            url.searchParams.delete(key);
        }
        // Reset page to 1 when filtering/searching
        if (key !== "page") {
            url.searchParams.set("page", "1");
        }
        window.location.href = url.toString();
    }
});

// Delete Confirmation
function confirmDelete(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción no se puede deshacer. Los usuarios asignados perderán este rol.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ef4444",
        cancelButtonColor: "#6b7280",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        background: "#ffffff",
        customClass: {
            title: "text-gray-800 font-bold",
            content: "text-gray-600",
        },
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("delete-form-" + id).submit();
        }
    });
}
