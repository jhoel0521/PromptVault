/**
 * Profile Page Interactivity
 */

document.addEventListener("DOMContentLoaded", function () {
    // 1. Password Visibility Toggle
    const toggleButtons = document.querySelectorAll(".toggle-password");

    toggleButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const input = this.previousElementSibling;
            const icon = this.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    });

    // 2. Avatar Preview
    // 2. Avatar Upload with AJAX
    const avatarInput = document.getElementById("avatarInput");
    const avatarPreview = document.querySelector(".profile-avatar");

    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (!file) return;

            // Preview immediately
            const reader = new FileReader();
            reader.onload = function (e) {
                avatarPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);

            // Upload via AJAX
            const formData = new FormData();
            formData.append("avatar", file);

            // Get CSRF Token
            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content");

            fetch("/perfil/avatar", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Update avatar with new URL
                        if (data.foto_url) {
                            avatarPreview.src = data.foto_url;
                        }
                        // Optional: Show success toast
                        console.log("Foto de perfil actualizada correctamente");
                        const successMsg = document.createElement('div');
                        successMsg.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #10b981; color: white; padding: 1rem 1.5rem; border-radius: 8px; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
                        successMsg.innerHTML = '<i class="fas fa-check-circle"></i> ' + (data.message || 'Foto actualizada');
                        document.body.appendChild(successMsg);
                        setTimeout(() => successMsg.remove(), 3000);
                    } else {
                        alert("Error al subir la imagen: " + (data.message || "Error desconocido"));
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("Error de conexión al subir imagen");
                });
        });
    }

    // 3. Form Animations
    const cards = document.querySelectorAll(".settings-card");
    cards.forEach((card, index) => {
        card.style.opacity = "0";
        card.style.transform = "translateY(20px)";
        setTimeout(() => {
            card.style.transition = "opacity 0.5s ease, transform 0.5s ease";
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        }, 100 * (index + 1));
    });
});
