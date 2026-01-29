# 🗂️ PromptVault

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.0-FF2D20?style=flat&logo=laravel" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?style=flat&logo=tailwind-css" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=flat&logo=alpine.js" alt="Alpine.js">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License MIT">
</p>

**PromptVault** es un sistema de gestión de prompts para IA con arquitectura SOLID, enfocado en seguridad, control de versiones y colaboración. Construido con Laravel 12, permite a los usuarios crear, organizar, compartir y versionar prompts con integración multi-proveedor de IA (Claude, Groq, Gemini).

---

## 📖 Índice

- [✨ Características Principales](#-características-principales)
- [🏗️ Arquitectura y Stack Tecnológico](#️-arquitectura-y-stack-tecnológico)
- [🚀 Instalación y Configuración](#-instalación-y-configuración)
- [⚙️ Configuración de Proveedores de IA](#️-configuración-de-proveedores-de-ia)
- [🧪 Testing](#-testing)
- [📚 Documentación Técnica](#-documentación-técnica)
- [🔐 Seguridad](#-seguridad)
- [📝 Licencia](#-licencia)

---

## ✨ Características Principales

### 🔒 **Gestión Segura de Prompts**
- CRUD completo con autorización granular mediante Policies
- Control de privacidad: público/privado por prompt
- Sistema de permisos basado en roles (admin, usuario, colaborador)
- Protección de privacidad: admins no pueden acceder a prompts privados

### 📜 **Versionado Inteligente**
- Historial automático de cambios en título y contenido
- Restauración a versiones anteriores con auditoría completa
- Comparación visual de diferencias entre versiones

### 🤝 **Colaboración y Compartición**
- Compartir prompts con usuarios específicos (lectura/escritura)
- Sistema de comentarios anidados con notificaciones
- Calificación de prompts (⭐ 1-5 estrellas)
- Panel de accesos compartidos con gestión de permisos

### 🤖 **Integración Multi-IA**
- **Claude (Anthropic)**: Soporte para modelos Claude 3
- **Groq**: API ultra-rápida con múltiples modelos LLM
- **Gemini (Google AI Studio)**: Integración con familia Gemini
- Chatbot interactivo con selección de provider y modelo
- Comando `php artisan check:models` para listar modelos disponibles

### 🎨 **UI/UX Moderna**
- 100% TailwindCSS (sin CSS custom)
- Alpine.js para interactividad reactiva
- Diseño responsive y accesible
- Modo mantenimiento integrado con UI administrativa

### 🛠️ **Administración Avanzada**
- Panel de configuración con variables .env editables
- Sistema de backups automáticos con descarga/restauración
- Gestión de usuarios, roles y permisos
- Dashboard de reportes con estadísticas en tiempo real

---

## 🏗️ Arquitectura y Stack Tecnológico

### **Backend**
- **Laravel 12** - Framework PHP moderno
- **PHP 8.2+** - Strict types, enums nativos
- **MySQL/SQLite** - Base de datos relacional
- **Arquitectura SOLID** - Repositorios, Servicios, Policies, Contracts

### **Frontend**
- **TailwindCSS 3.x** - Utility-first CSS framework
- **Alpine.js 3.x** - Framework JavaScript reactivo
- **Vite** - Build tool ultra-rápido
- **Blade Components** - Sistema de componentes reutilizables

### **Testing**
- **PHPUnit 11.5** - Framework de testing PHP
- **Pest (opcional)** - Syntax alternativo para tests
- Cobertura: Models, Services, Policies, Feature Tests

### **Dependencias Clave**
- `lucianotonet/groq-php` - SDK oficial de Groq
- `laravel/breeze` - Autenticación con Blade + Alpine
- `laravel/pint` - Code style fixer (Laravel PSR-12)

---

## 🚀 Instalación y Configuración

### **Requisitos Previos**
- PHP >= 8.2
- Composer >= 2.x
- Node.js >= 18.x & npm
- MySQL/MariaDB o SQLite
- Extensiones PHP: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `curl`

### **Instalación Rápida (Recomendada)**

```bash
# 1. Clonar el repositorio
git clone https://github.com/tu-usuario/PromptVault.git
cd PromptVault

# 2. Ejecutar instalación automática
composer setup

# 3. Ejecutar migraciones y seeders
php artisan migrate:fresh --seed --force

# 4. Iniciar entorno de desarrollo (concurrente)
composer dev
```

### **Instalación Manual (Paso a Paso)**

```bash
# 1. Instalar dependencias PHP
composer install

# 2. Crear archivo .env desde plantilla
cp .env.example .env

# 3. Generar clave de aplicación
php artisan key:generate

# 4. Configurar base de datos en .env
# Editar DB_CONNECTION, DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 5. Ejecutar migraciones
php artisan migrate --force

# 6. Sembrar datos iniciales (opcional)
php artisan db:seed --force

# 7. Instalar dependencias frontend
npm install

# 8. Compilar assets
npm run build

# 9. Iniciar servidor de desarrollo
php artisan serve
# En otra terminal:
npm run dev
```

### **Datos de Prueba Iniciales**

El seeder crea un usuario administrador por defecto:

- **Email:** `admin@promptvault.local`
- **Password:** `password`

---

## ⚙️ Configuración de Proveedores de IA

Edita el archivo `.env` y agrega las API keys de los proveedores que desees usar:

```env
# Claude (Anthropic)
ANTHROPIC_API_KEY=sk-ant-xxxxxxxxxxxxx

# Groq
GROQ_API_KEY=gsk_xxxxxxxxxxxxx

# Gemini (Google AI Studio)
GEMINI_API_KEY=AIzaSyxxxxxxxxxxxxx
```

### **Verificar Modelos Disponibles**

```bash
php artisan check:models
```

Este comando lista todos los modelos activos por proveedor:
- ✅ Modelos configurados (con API key válida)
- ❌ Modelos inactivos (sin API key)

---

## 🧪 Testing

### **Ejecutar Tests**

```bash
# Todos los tests
composer test

# Tests específicos
php artisan test --filter=PromptTest

# Con cobertura de código
php artisan test --coverage
```

### **Estructura de Tests**

```
tests/
├── Unit/
│   ├── Models/         # Tests de relaciones y scopes
│   └── Services/       # Tests de lógica de negocio
└── Feature/
    ├── Prompts/        # Tests de CRUD, visibilidad, versionado
    ├── Sharing/        # Tests de compartición y colaboración
    ├── Comments/       # Tests de comentarios
    └── Auth/           # Tests de autenticación y autorización
```

📄 Ver: [docs/fase4-plan-integral-testing.md](docs/fase4-plan-integral-testing.md) para plan detallado de testing.

---

## 📚 Documentación Técnica

La carpeta `docs/` contiene documentación detallada de todas las fases del proyecto:

| Documento | Descripción |
|-----------|-------------|
| [`AGENTS.md`](AGENTS.md) | 🤖 Protocolo de desarrollo para agentes IA (SOLID, commits, task.md) |
| [`task.md`](task.md) | 📋 Lista de tareas activas, completadas y planificadas (TODO maestro) |
| [`docs/fase1-auditoria-seguridad-implementacion-prompts.md`](docs/fase1-auditoria-seguridad-implementacion-prompts.md) | 🔐 Auditoría de seguridad y refactorización de módulo Prompts |
| [`docs/docs-migration-css-to-tailwind.md`](docs/docs-migration-css-to-tailwind.md) | 🎨 Migración completa de CSS custom a TailwindCSS (59 archivos) |
| [`docs/fase4-plan-integral-testing.md`](docs/fase4-plan-integral-testing.md) | 🧪 Plan de implementación de suite de tests (Unit + Feature) |
| [`docs/implementacion-base-datos-plan-pruebas.md`](docs/implementacion-base-datos-plan-pruebas.md) | 🗄️ Diseño de base de datos y plan de pruebas inicial |
| [`docs/test-results.md`](docs/test-results.md) | ✅ Resultados de ejecución de tests automatizados |

### **Bitácora de Desarrollo**

Todos los cambios técnicos están documentados en:
- **[`task.md`](task.md)**: Bitácora cronológica con descripción de archivos modificados, decisiones arquitectónicas y estado de tareas.

---

## 🔐 Seguridad

### **Principios Implementados**
- ✅ **Autorización en capas**: FormRequests + Policies + Middleware
- ✅ **CSRF Protection**: Habilitado en todos los formularios
- ✅ **SQL Injection**: 100% consultas con Eloquent/Query Builder
- ✅ **XSS Protection**: Escape automático en Blade (`{{ }}`)
- ✅ **Mass Assignment**: Protección con `$fillable`/`$guarded`
- ✅ **Rate Limiting**: Limitación de intentos de login
- ✅ **Privacidad**: Admins no acceden a prompts privados

### **Auditorías de Seguridad**

📄 Ver: [docs/fase1-auditoria-seguridad-implementacion-prompts.md](docs/fase1-auditoria-seguridad-implementacion-prompts.md)

### **Reportar Vulnerabilidades**

Si descubres una vulnerabilidad de seguridad, por favor envía un email a **seguridad@promptvault.local** en lugar de abrir un issue público.

---

## 📝 Licencia

Este proyecto está licenciado bajo la [Licencia MIT](https://opensource.org/licenses/MIT).

**Copyright © 2026 PromptVault**

Laravel Framework es open-source licenciado bajo [MIT license](https://opensource.org/licenses/MIT).

---

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor sigue estas guías:

1. **Fork** el proyecto
2. Crea una **rama** para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. **Commitea** tus cambios siguiendo [Conventional Commits](https://www.conventionalcommits.org/)
4. Ejecuta **`./vendor/bin/pint`** para formatear el código
5. Ejecuta **`composer test`** para verificar que todos los tests pasen
6. **Push** a la rama (`git push origin feature/nueva-funcionalidad`)
7. Abre un **Pull Request**

📄 Ver protocolo completo en: [`AGENTS.md`](AGENTS.md)

---

<p align="center">Hecho con ❤️ usando Laravel 12</p>
