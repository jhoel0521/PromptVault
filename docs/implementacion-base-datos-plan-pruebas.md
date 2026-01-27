# PromptVault - Documentación Técnica

## Implementación de Base de Datos y Plan de Pruebas

**Versión:** 1.0
**Fecha:** 2026-01-27
**Base de datos:** MySQL
**Framework:** Laravel 11.x

---

## Parte 1: Implementación de Base de Datos

### 1.1 Diagrama Entidad-Relación (Conceptual)

```
┌─────────────┐       ┌─────────────┐       ┌─────────────┐
│   roles     │       │   users     │       │   prompts   │
├─────────────┤       ├─────────────┤       ├─────────────┤
│ id (PK)     │◄──────│ role_id(FK) │       │ id (PK)     │
│ nombre      │       │ id (PK)     │◄──────│ user_id(FK) │
│ descripcion │       │ name        │       │ titulo      │
│ nivel_acceso│       │ email       │       │ contenido   │
│ timestamps  │       │ password    │       │ descripcion │
└─────────────┘       │ cuenta_activa       │ visibilidad │
      │               │ ultimo_acceso       │ version_actual
      │               │ foto_perfil │       │ promedio_cal│
      ▼               │ timestamps  │       │ conteo_vistas
┌─────────────┐       └─────────────┘       │ timestamps  │
│  permisos   │              │              └─────────────┘
├─────────────┤              │                    │
│ id (PK)     │              │                    │
│ nombre      │              │         ┌──────────┼──────────┐
│ descripcion │              │         │          │          │
│ modulo      │              │         ▼          ▼          ▼
│ timestamps  │         ┌─────────┐ ┌─────────┐ ┌─────────┐
└─────────────┘         │versiones│ │etiquetas│ │califica-│
      │                 ├─────────┤ ├─────────┤ │ciones   │
      ▼                 │id (PK)  │ │id (PK)  │ ├─────────┤
┌─────────────┐         │prompt_id│ │nombre   │ │id (PK)  │
│role_permiso │         │numero_v.│ │color_hex│ │prompt_id│
├─────────────┤         │contenido│ │timestamps│ user_id  │
│ id (PK)     │         │mensaje  │ └─────────┘ │estrellas│
│ role_id(FK) │         │timestamps            │resena   │
│ permiso_id  │         └─────────┘             │timestamps
│ timestamps  │                                 └─────────┘
└─────────────┘
```

### 1.2 Descripción de Tablas

#### 1.2.1 Tablas del Sistema de Roles y Permisos

| Tabla | Descripción | Registros Iniciales |
|-------|-------------|---------------------|
| `roles` | Define los roles del sistema | 4 (admin, user, collaborator, guest) |
| `permisos` | Permisos granulares por módulo | 41 permisos en 9 módulos |
| `role_permiso` | Tabla pivote roles-permisos | Variable según configuración |

**Estructura: `roles`**
```sql
CREATE TABLE roles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) UNIQUE NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    nivel_acceso INT DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Roles predefinidos:**
| ID | Nombre | Nivel Acceso | Descripción |
|----|--------|--------------|-------------|
| 1 | admin | 100 | Control total del sistema |
| 2 | user | 10 | Usuario estándar |
| 3 | collaborator | 15 | Permisos ampliados |
| 4 | guest | 1 | Acceso por token |

#### 1.2.2 Tablas de Usuarios

| Tabla | Descripción |
|-------|-------------|
| `users` | Usuarios del sistema |
| `password_reset_tokens` | Tokens para recuperación de contraseña |
| `sessions` | Sesiones activas (driver: database) |

**Estructura: `users`**
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_id BIGINT UNSIGNED DEFAULT 2,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    cuenta_activa BOOLEAN DEFAULT TRUE,
    ultimo_acceso TIMESTAMP NULL,
    foto_perfil VARCHAR(255) NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT
);
```

#### 1.2.3 Tablas del Core de Prompts

| Tabla | Descripción | Relaciones |
|-------|-------------|------------|
| `prompts` | Prompts principales | users (N:1) |
| `versiones` | Historial de versiones | prompts (N:1) |
| `etiquetas` | Etiquetas/tags | prompts (N:M) |
| `prompt_etiquetas` | Pivote prompts-etiquetas | - |

**Estructura: `prompts`**
```sql
CREATE TABLE prompts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    contenido TEXT NOT NULL,
    descripcion TEXT NULL,
    visibilidad ENUM('privado', 'publico', 'enlace') DEFAULT 'privado',
    version_actual INT DEFAULT 1,
    promedio_calificacion DECIMAL(3,2) DEFAULT 0.00,
    conteo_vistas INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

**Estructura: `versiones`**
```sql
CREATE TABLE versiones (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    prompt_id BIGINT UNSIGNED NOT NULL,
    numero_version INT NOT NULL,
    contenido TEXT NOT NULL,
    mensaje_cambio VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (prompt_id) REFERENCES prompts(id) ON DELETE CASCADE
);
```

**Estructura: `etiquetas`**
```sql
CREATE TABLE etiquetas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) UNIQUE NOT NULL,
    color_hex VARCHAR(7) DEFAULT '#E5E7EB',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

#### 1.2.4 Tablas de Colaboración

| Tabla | Descripción | Constraint Único |
|-------|-------------|------------------|
| `accesos_compartidos` | Accesos tipo Google Docs | (prompt_id, user_id) |
| `comentarios` | Comentarios anidados | - |
| `calificaciones` | Sistema de estrellas | (prompt_id, user_id) |

**Estructura: `accesos_compartidos`**
```sql
CREATE TABLE accesos_compartidos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    prompt_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    nivel_acceso ENUM('lector', 'comentador', 'editor') DEFAULT 'lector',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY (prompt_id, user_id),
    FOREIGN KEY (prompt_id) REFERENCES prompts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

**Estructura: `comentarios`** (con soporte para hilos)
```sql
CREATE TABLE comentarios (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    prompt_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    contenido TEXT NOT NULL,
    parent_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (prompt_id) REFERENCES prompts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES comentarios(id) ON DELETE CASCADE
);
```

**Estructura: `calificaciones`**
```sql
CREATE TABLE calificaciones (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    prompt_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    estrellas TINYINT UNSIGNED NOT NULL,
    resena TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY (prompt_id, user_id),
    FOREIGN KEY (prompt_id) REFERENCES prompts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

#### 1.2.5 Tablas de Configuración y Sistema

| Tabla | Descripción |
|-------|-------------|
| `app_settings` | Configuración global de la aplicación |
| `eventos` | Calendario de eventos |
| `cache` / `cache_locks` | Sistema de caché |
| `jobs` / `job_batches` / `failed_jobs` | Sistema de colas |

**Estructura: `app_settings`**
```sql
CREATE TABLE app_settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    -- Configuración general
    app_name VARCHAR(255) DEFAULT 'PromptVault',
    app_url VARCHAR(255) NULL,
    app_env VARCHAR(255) DEFAULT 'local',
    app_locale VARCHAR(255) DEFAULT 'en',
    -- Contacto
    support_email VARCHAR(255) NULL,
    contact_phone VARCHAR(255) NULL,
    -- Estado
    maintenance_mode BOOLEAN DEFAULT FALSE,
    description TEXT NULL,
    theme VARCHAR(255) DEFAULT 'dark',
    language VARCHAR(255) DEFAULT 'es',
    -- Mail
    mail_mailer VARCHAR(255) DEFAULT 'log',
    mail_host VARCHAR(255) NULL,
    mail_port INT NULL,
    mail_from_address VARCHAR(255) NULL,
    mail_from_name VARCHAR(255) NULL,
    -- Sistema
    session_driver VARCHAR(255) DEFAULT 'file',
    cache_store VARCHAR(255) DEFAULT 'file',
    queue_connection VARCHAR(255) DEFAULT 'sync',
    -- Seguridad
    two_fa_enabled BOOLEAN DEFAULT FALSE,
    session_timeout INT DEFAULT 120,
    max_login_attempts INT DEFAULT 5,
    geo_blocking_enabled BOOLEAN DEFAULT TRUE,
    -- Políticas de contraseña
    password_min_length INT DEFAULT 12,
    password_expiry_days INT DEFAULT 90,
    password_require_special_chars BOOLEAN DEFAULT TRUE,
    password_force_rotation BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Estructura: `eventos`**
```sql
CREATE TABLE eventos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NULL,
    fecha_inicio DATETIME NOT NULL,
    fecha_fin DATETIME NULL,
    tipo VARCHAR(255) DEFAULT 'personal',
    ubicacion VARCHAR(255) NULL,
    todo_el_dia BOOLEAN DEFAULT FALSE,
    completado BOOLEAN DEFAULT FALSE,
    color VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### 1.3 Relaciones entre Modelos (Eloquent)

```php
// User.php
User hasMany Prompt
User hasMany AccesoCompartido
User hasMany Comentario
User hasMany Calificacion
User hasMany Evento
User belongsTo Role
User belongsToMany Prompt (through accesos_compartidos)

// Prompt.php
Prompt belongsTo User
Prompt hasMany Version
Prompt hasMany AccesoCompartido
Prompt hasMany Comentario
Prompt hasMany Calificacion
Prompt belongsToMany Etiqueta (through prompt_etiquetas)
Prompt belongsToMany User (through accesos_compartidos)

// Role.php
Role hasMany User
Role belongsToMany Permiso (through role_permiso)

// Comentario.php
Comentario belongsTo Prompt
Comentario belongsTo User
Comentario belongsTo Comentario (parent_id - self-referential)
Comentario hasMany Comentario (replies)
```

### 1.4 Orden de Ejecución de Migraciones

```bash
# Ejecutar migraciones en orden
php artisan migrate

# Orden cronológico:
# 1. 0001_01_01_000000_create_roles_table
# 2. 0001_01_01_000001_create_cache_table
# 3. 0001_01_01_000001_create_users_table
# 4. 0001_01_01_000002_create_jobs_table
# 5. 2026_01_06_190502_create_etiquetas_table
# 6. 2026_01_06_190502_create_prompts_table
# 7. 2026_01_06_190503_create_versiones_table
# 8. 2026_01_06_190506_create_prompt_etiquetas_table
# 9. 2026_01_06_190507_create_accesos_compartidos_table
# 10. 2026_01_06_190508_create_comentarios_table
# 11. 2026_01_06_190509_create_calificaciones_table
# 12. 2026_01_06_191522_create_permisos_table
# 13. 2026_01_06_191522_create_role_permiso_table
# 14. 2026_01_20_192849_create_eventos_table
# 15. 2026_01_21_181533_create_app_settings_table
```

### 1.5 Orden de Ejecución de Seeders

```php
// DatabaseSeeder.php - Orden de ejecución
1. RoleSeeder          // Roles del sistema
2. PermisoSeeder       // Permisos + asignación a roles
3. EtiquetaSeeder      // Etiquetas predefinidas
4. Usuarios base       // admin@promptvault.com, user@promptvault.com
5. UserSeeder          // Usuarios adicionales
6. PromptSeeder        // Prompts de ejemplo
7. VersionSeeder       // Versiones de prompts
8. EventoSeeder        // Eventos de calendario
9. AccesoCompartidoSeeder  // Accesos compartidos
10. ComentarioSeeder   // Comentarios
11. CalificacionSeeder // Calificaciones
```

**Comando para ejecutar:**
```bash
php artisan db:seed
# O para fresh start:
php artisan migrate:fresh --seed
```

### 1.6 Usuarios de Prueba

| Email | Contraseña | Rol | Propósito |
|-------|------------|-----|-----------|
| admin@promptvault.com | password | admin | Pruebas administrativas |
| user@promptvault.com | password | user | Pruebas de usuario estándar |

---

## Parte 2: Plan de Pruebas

### 2.1 Estructura de Tests Existente

```
tests/
├── Feature/
│   ├── Auth/
│   │   ├── AuthenticationTest.php
│   │   ├── EmailVerificationTest.php
│   │   ├── PasswordConfirmationTest.php
│   │   ├── PasswordResetTest.php
│   │   ├── PasswordUpdateTest.php
│   │   └── RegistrationTest.php
│   ├── ExampleTest.php
│   └── ProfileTest.php
├── Unit/
│   └── ExampleTest.php
└── TestCase.php
```

### 2.2 Tests de Autenticación (Existentes)

| Test | Archivo | Estado |
|------|---------|--------|
| Renderizado de login | AuthenticationTest.php | Implementado |
| Login exitoso | AuthenticationTest.php | Implementado |
| Login fallido (password inválido) | AuthenticationTest.php | Implementado |
| Logout | AuthenticationTest.php | Implementado |
| Registro de usuario | RegistrationTest.php | Implementado |
| Verificación de email | EmailVerificationTest.php | Implementado |
| Reset de password | PasswordResetTest.php | Implementado |
| Actualización de password | PasswordUpdateTest.php | Implementado |
| Confirmación de password | PasswordConfirmationTest.php | Implementado |

### 2.3 Plan de Tests a Implementar

#### 2.3.1 Tests Unitarios (Unit Tests)

```php
// tests/Unit/Models/
├── UserTest.php
│   ├── test_user_has_role_relationship
│   ├── test_user_es_admin_returns_true_for_admin
│   ├── test_user_es_admin_returns_false_for_user
│   ├── test_user_tiene_permiso_checks_role_permissions
│   ├── test_user_puede_editar_own_prompt
│   ├── test_user_puede_editar_shared_prompt_as_editor
│   └── test_user_cannot_edit_others_prompt
│
├── PromptTest.php
│   ├── test_prompt_belongs_to_user
│   ├── test_prompt_has_many_versiones
│   ├── test_prompt_has_many_etiquetas
│   ├── test_prompt_recalcular_promedio
│   ├── test_prompt_incrementar_vistas
│   ├── test_prompt_es_visible_para_owner
│   ├── test_prompt_es_visible_para_public
│   ├── test_prompt_es_visible_para_shared_user
│   └── test_prompt_not_visible_for_private
│
├── RoleTest.php
│   ├── test_role_has_many_users
│   ├── test_role_has_many_permisos
│   └── test_role_tiene_permiso
│
├── VersionTest.php
│   ├── test_version_belongs_to_prompt
│   └── test_version_has_numero_version
│
├── ComentarioTest.php
│   ├── test_comentario_belongs_to_prompt
│   ├── test_comentario_belongs_to_user
│   ├── test_comentario_can_have_parent
│   └── test_comentario_can_have_replies
│
└── CalificacionTest.php
    ├── test_calificacion_belongs_to_prompt
    ├── test_calificacion_belongs_to_user
    └── test_calificacion_estrellas_range
```

#### 2.3.2 Tests de Feature (Integration Tests)

```php
// tests/Feature/
├── Prompts/
│   ├── PromptCrudTest.php
│   │   ├── test_user_can_create_prompt
│   │   ├── test_user_can_view_own_prompts
│   │   ├── test_user_can_update_own_prompt
│   │   ├── test_user_can_delete_own_prompt
│   │   ├── test_user_cannot_delete_others_prompt
│   │   └── test_admin_can_delete_any_prompt
│   │
│   ├── PromptVisibilityTest.php
│   │   ├── test_public_prompts_visible_to_all
│   │   ├── test_private_prompts_hidden_from_others
│   │   ├── test_link_prompts_accessible_with_token
│   │   └── test_shared_prompts_visible_to_shared_users
│   │
│   └── PromptVersioningTest.php
│       ├── test_editing_prompt_creates_new_version
│       ├── test_user_can_view_version_history
│       ├── test_user_can_restore_previous_version
│       └── test_version_comparison_works
│
├── Sharing/
│   ├── AccesoCompartidoTest.php
│   │   ├── test_owner_can_share_prompt
│   │   ├── test_share_with_lector_level
│   │   ├── test_share_with_comentador_level
│   │   ├── test_share_with_editor_level
│   │   ├── test_owner_can_revoke_access
│   │   └── test_shared_user_receives_notification
│   │
│   └── CollaborationTest.php
│       ├── test_editor_can_edit_shared_prompt
│       ├── test_comentador_can_comment_not_edit
│       └── test_lector_can_only_view
│
├── Comments/
│   └── ComentarioTest.php
│       ├── test_user_can_comment_on_public_prompt
│       ├── test_user_can_reply_to_comment
│       ├── test_owner_can_delete_comment
│       ├── test_user_can_delete_own_comment
│       └── test_nested_comments_display_correctly
│
├── Ratings/
│   └── CalificacionTest.php
│       ├── test_user_can_rate_prompt
│       ├── test_user_can_update_rating
│       ├── test_user_cannot_rate_twice
│       ├── test_prompt_average_updates_on_rating
│       └── test_rating_range_validation
│
├── Tags/
│   └── EtiquetaTest.php
│       ├── test_user_can_add_tags_to_prompt
│       ├── test_user_can_remove_tags_from_prompt
│       ├── test_admin_can_create_global_tags
│       └── test_filter_prompts_by_tag
│
├── Admin/
│   ├── UserManagementTest.php
│   │   ├── test_admin_can_list_users
│   │   ├── test_admin_can_create_user
│   │   ├── test_admin_can_deactivate_user
│   │   ├── test_admin_can_change_user_role
│   │   └── test_non_admin_cannot_access_user_management
│   │
│   └── ConfigurationTest.php
│       ├── test_admin_can_view_settings
│       ├── test_admin_can_update_settings
│       └── test_non_admin_cannot_access_settings
│
└── Calendar/
    └── EventoTest.php
        ├── test_user_can_create_event
        ├── test_user_can_view_own_events
        ├── test_user_can_update_event
        ├── test_user_can_delete_event
        └── test_user_can_mark_event_complete
```

### 2.4 Casos de Prueba Detallados

#### 2.4.1 CP-001: Gestión de Prompts

| ID | Caso de Prueba | Precondiciones | Pasos | Resultado Esperado |
|----|----------------|----------------|-------|-------------------|
| CP-001-01 | Crear prompt | Usuario autenticado | 1. Ir a /prompts/create 2. Llenar formulario 3. Guardar | Prompt creado, versión 1 |
| CP-001-02 | Editar prompt propio | Usuario con prompt | 1. Ir a /prompts/{id}/edit 2. Modificar 3. Guardar | Prompt actualizado, nueva versión |
| CP-001-03 | Eliminar prompt | Usuario propietario | 1. Ir a /prompts/{id} 2. Click eliminar 3. Confirmar | Prompt eliminado (cascade) |
| CP-001-04 | Ver historial versiones | Prompt con versiones | 1. Ir a /prompts/{id}/versions | Lista de versiones visible |
| CP-001-05 | Restaurar versión | Prompt con versiones | 1. Ir a versiones 2. Click restaurar | Contenido restaurado |

#### 2.4.2 CP-002: Sistema de Compartir

| ID | Caso de Prueba | Precondiciones | Pasos | Resultado Esperado |
|----|----------------|----------------|-------|-------------------|
| CP-002-01 | Compartir como lector | Usuario propietario | 1. Ir a prompt 2. Compartir 3. Seleccionar lector | Usuario puede ver, no editar |
| CP-002-02 | Compartir como editor | Usuario propietario | 1. Ir a prompt 2. Compartir 3. Seleccionar editor | Usuario puede editar |
| CP-002-03 | Revocar acceso | Prompt compartido | 1. Ir a gestión 2. Revocar | Usuario pierde acceso |
| CP-002-04 | Acceso por enlace | Prompt visibilidad=enlace | 1. Generar enlace 2. Acceder | Acceso sin login |

#### 2.4.3 CP-003: Comentarios y Calificaciones

| ID | Caso de Prueba | Precondiciones | Pasos | Resultado Esperado |
|----|----------------|----------------|-------|-------------------|
| CP-003-01 | Agregar comentario | Prompt público | 1. Ver prompt 2. Escribir comentario 3. Enviar | Comentario visible |
| CP-003-02 | Responder comentario | Comentario existente | 1. Click responder 2. Escribir 3. Enviar | Respuesta anidada |
| CP-003-03 | Calificar prompt | Prompt público | 1. Ver prompt 2. Seleccionar estrellas 3. Guardar | Calificación guardada |
| CP-003-04 | Actualizar calificación | Calificación existente | 1. Ver prompt 2. Cambiar estrellas | Calificación actualizada |
| CP-003-05 | Ver promedio | Prompt con calificaciones | 1. Ver prompt | Promedio calculado correctamente |

#### 2.4.4 CP-004: Administración

| ID | Caso de Prueba | Precondiciones | Pasos | Resultado Esperado |
|----|----------------|----------------|-------|-------------------|
| CP-004-01 | Listar usuarios | Admin autenticado | 1. Ir a /admin/users | Lista de usuarios |
| CP-004-02 | Desactivar usuario | Admin, usuario activo | 1. Click desactivar | cuenta_activa = false |
| CP-004-03 | Cambiar rol | Admin, usuario | 1. Editar usuario 2. Cambiar rol | Rol actualizado |
| CP-004-04 | Configurar app | Admin | 1. Ir a settings 2. Modificar | Configuración guardada |
| CP-004-05 | Acceso denegado | Usuario normal | 1. Intentar /admin/* | Error 403 |

### 2.5 Comandos de Ejecución de Tests

```bash
# Ejecutar todos los tests
php artisan test

# Ejecutar tests con cobertura
php artisan test --coverage

# Ejecutar solo tests unitarios
php artisan test --testsuite=Unit

# Ejecutar solo tests de feature
php artisan test --testsuite=Feature

# Ejecutar tests específicos
php artisan test --filter=PromptCrudTest
php artisan test --filter=test_user_can_create_prompt

# Ejecutar tests en paralelo
php artisan test --parallel

# Ejecutar con output detallado
php artisan test --verbose
```

### 2.6 Configuración de Entorno de Pruebas

**phpunit.xml** (configuración actual)
```xml
<php>
    <env name="APP_ENV" value="testing"/>
    <env name="APP_MAINTENANCE_DRIVER" value="file"/>
    <env name="BCRYPT_ROUNDS" value="4"/>
    <env name="CACHE_STORE" value="array"/>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
    <env name="MAIL_MAILER" value="array"/>
    <env name="PULSE_ENABLED" value="false"/>
    <env name="QUEUE_CONNECTION" value="sync"/>
    <env name="SESSION_DRIVER" value="array"/>
    <env name="TELESCOPE_ENABLED" value="false"/>
</php>
```

### 2.7 Factories Requeridas

```php
// database/factories/
├── UserFactory.php         ✓ Existe
├── PromptFactory.php       ○ Por crear
├── VersionFactory.php      ○ Por crear
├── EtiquetaFactory.php     ○ Por crear
├── ComentarioFactory.php   ○ Por crear
├── CalificacionFactory.php ○ Por crear
├── EventoFactory.php       ○ Por crear
└── RoleFactory.php         ○ Por crear
```

### 2.8 Métricas de Calidad

| Métrica | Objetivo | Estado Actual |
|---------|----------|---------------|
| Cobertura de código | > 80% | Por medir |
| Tests unitarios | > 50 | 2 (ejemplo) |
| Tests de integración | > 30 | 10 (auth) |
| Tests de regresión | Automatizados | CI pendiente |
| Tiempo de ejecución | < 60s | Por medir |

### 2.9 Checklist de Validación de Base de Datos

- [ ] Todas las migraciones ejecutan sin errores
- [ ] Foreign keys configuradas correctamente
- [ ] Índices en columnas de búsqueda frecuente
- [ ] Seeders ejecutan en orden correcto
- [ ] Usuarios de prueba creados
- [ ] Cascade deletes funcionan correctamente
- [ ] Unique constraints previenen duplicados
- [ ] Enums validados en aplicación

---

## Apéndice A: Comandos Útiles

```bash
# Crear base de datos y ejecutar migraciones
php artisan migrate:fresh --seed

# Ver estado de migraciones
php artisan migrate:status

# Rollback última migración
php artisan migrate:rollback

# Crear nueva migración
php artisan make:migration create_tabla_table

# Crear modelo con migración y factory
php artisan make:model NombreModelo -mf

# Crear test
php artisan make:test NombreTest
php artisan make:test NombreTest --unit

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

## Apéndice B: Diagrama de Dependencias de Seeders

```
RoleSeeder
    └── PermisoSeeder (asigna permisos a roles)
            └── EtiquetaSeeder
                    └── Usuarios Base (admin, user)
                            └── UserSeeder
                                    └── PromptSeeder
                                            ├── VersionSeeder
                                            ├── EventoSeeder
                                            ├── AccesoCompartidoSeeder
                                            ├── ComentarioSeeder
                                            └── CalificacionSeeder
```

---

**Documento generado automáticamente**
**PromptVault v1.0**
