/**
 * FOOTER COMPONENT LOGIC
 */

document.addEventListener("DOMContentLoaded", () => {
    // Version Button Interaction
    const versionBtn = document.querySelector(".version-btn");

    if (versionBtn) {
        versionBtn.addEventListener("click", () => {
            // Simple toast or alert for now, or just a console log
            // Ideally this would use a toast system if available
            alert(
                "Sistema Educativo Tech Home - Versión 2.0 (Build #2025.1)\nEstado: Actualizado"
            );
        });
    }

    // Social Links Hover Effect (Optional JS enhancement)
    const socialLinks = document.querySelectorAll(".social-link");
    socialLinks.forEach((link) => {
        link.addEventListener("mouseenter", () => {
            link.style.transform = "translateY(-5px) scale(1.1)";
        });

        link.addEventListener("mouseleave", () => {
            link.style.transform = "translateY(0) scale(1)";
        });
    });
});
