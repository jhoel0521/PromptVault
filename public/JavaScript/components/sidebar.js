/**
 * SIDEBAR MANAGER - OPTIMIZED
 */
/**
 * SIDEBAR MANAGER - RESTORED & OPTIMIZED
 * Handles sidebar interactions, submenus, and theme toggling
 */

class SidebarManager {
    constructor() {
        this.sidebar = document.getElementById("systemSidebar");
        this.themeSwitch = document.getElementById("themeSwitch");
        this.toggleBtn = document.querySelector(".sidebar-toggle-btn");
        this.navItems = document.querySelectorAll(".nav-item");

        this.init();
    }

    init() {
        this.setupThemeToggle();
        this.setupMobileToggle();
        this.setupSubmenus();
        this.highlightActiveItem();
        this.restoreState();
    }

    setupThemeToggle() {
        if (!this.themeSwitch) return;

        // Load saved theme
        const savedTheme = localStorage.getItem("theme");
        if (savedTheme === "dark") {
            document.body.classList.add("dark-mode");
            this.themeSwitch.checked = true;
        }

        this.themeSwitch.addEventListener("change", (e) => {
            const isDark = e.target.checked;
            document.body.classList.toggle("dark-mode", isDark);
            localStorage.setItem("theme", isDark ? "dark" : "light");
        });
    }

    setupMobileToggle() {
        if (this.toggleBtn && this.sidebar) {
            this.toggleBtn.addEventListener("click", () => {
                this.sidebar.classList.toggle("show");
            });

            // Close when clicking outside
            document.addEventListener("click", (e) => {
                if (
                    window.innerWidth <= 1024 &&
                    this.sidebar.classList.contains("show") &&
                    !this.sidebar.contains(e.target) &&
                    !this.toggleBtn.contains(e.target)
                ) {
                    this.sidebar.classList.remove("show");
                }
            });
        }
    }

    setupSubmenus() {
        this.navItems.forEach((item) => {
            const toggle = item.querySelector(".submenu-toggle");
            const submenu = item.querySelector(".submenu");

            if (toggle && submenu) {
                toggle.addEventListener("click", (e) => {
                    e.preventDefault();

                    // Close other submenus
                    this.navItems.forEach((otherItem) => {
                        if (
                            otherItem !== item &&
                            otherItem.classList.contains("open")
                        ) {
                            otherItem.classList.remove("open");
                            const otherSubmenu =
                                otherItem.querySelector(".submenu");
                            if (otherSubmenu)
                                otherSubmenu.style.maxHeight = null;
                        }
                    });

                    // Toggle current
                    item.classList.toggle("open");
                    if (item.classList.contains("open")) {
                        submenu.style.maxHeight = submenu.scrollHeight + "px";
                    } else {
                        submenu.style.maxHeight = null;
                    }
                });
            }
        });
    }

    highlightActiveItem() {
        const currentPath = window.location.pathname;

        // Highlight regular links
        this.sidebar?.querySelectorAll(".nav-link").forEach((link) => {
            if (link.getAttribute("href") === currentPath) {
                link.classList.add("active");

                // If inside submenu, open it
                const parentItem = link.closest(".nav-item");
                if (parentItem && parentItem.querySelector(".submenu")) {
                    parentItem.classList.add("open");
                    const submenu = parentItem.querySelector(".submenu");
                    submenu.style.maxHeight = submenu.scrollHeight + "px";
                }
            }
        });

        // Highlight submenu links
        this.sidebar?.querySelectorAll(".submenu-link").forEach((link) => {
            if (link.getAttribute("href") === currentPath) {
                link.classList.add("active");
                const parentItem = link.closest(".nav-item");
                if (parentItem) {
                    parentItem.classList.add("open");
                    const submenu = parentItem.querySelector(".submenu");
                    submenu.style.maxHeight = submenu.scrollHeight + "px";
                }
            }
        });
    }

    restoreState() {
        // State restoration logic if needed in future
    }
}

// Initialize
document.addEventListener("DOMContentLoaded", () => {
    new SidebarManager();
});
