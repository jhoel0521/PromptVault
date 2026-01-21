import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

const THEME_KEY = 'theme';

// Aplica la clase 'dark' en html/body y sincroniza el switch
function applyTheme(mode) {
	const isDark = mode === 'dark';
	document.documentElement.classList.toggle('dark', isDark);
	document.body.classList.toggle('dark', isDark);

	const toggle = document.getElementById('themeSwitch');
	if (toggle) {
		toggle.checked = isDark;
	}
}

// Inicializa el tema leyendo localStorage o prefers-color-scheme
function initThemeToggle() {
	const stored = localStorage.getItem(THEME_KEY);
	const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
	const initial = stored || (prefersDark ? 'dark' : 'light');
	applyTheme(initial);

	document.addEventListener('DOMContentLoaded', () => {
		const toggle = document.getElementById('themeSwitch');
		if (toggle) {
			toggle.addEventListener('change', (e) => {
				const mode = e.target.checked ? 'dark' : 'light';
				applyTheme(mode);
				localStorage.setItem(THEME_KEY, mode);
			});
		}
	});
}

initThemeToggle();
Alpine.start();