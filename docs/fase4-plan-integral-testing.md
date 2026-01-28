# Fase 4: Plan Integral de Testing

**Objetivo:** Implementación de suite de pruebas automatizadas para todas las funcionalidades críticas de PromptVault.

**Estado:** Planificación completada, lista para iniciarse  
**Fecha de Creación:** 28 de enero de 2026  
**Alcance:** Tests unitarios + Tests de integración (Feature tests)

---

## 📋 Resumen Ejecutivo

| Fase | Tareas | Estado | Prioridad | Est. Líneas Tests |
|------|--------|--------|-----------|-------------------|
| **4** | 22-35 (14 tareas) | 🚀 EN INICIO | CRÍTICA/ALTA | ~2,500+ |

### Desglose por Tipo de Test

```
📊 Tests Unitarios
├── Models (8 tests)
│   ├── UserTest.php
│   ├── PromptTest.php
│   ├── RoleTest.php
│   ├── VersionTest.php
│   ├── ComentarioTest.php
│   ├── CalificacionTest.php
│   ├── EtiquetaTest.php
│   └── AccesoCompartidoTest.php
│
└── Services (4 test files)
    ├── CalificacionService
    ├── CompartirService
    ├── PromptService
    └── ConfigurationService + BackupService

📊 Tests de Integración (Feature)
├── Prompts/ (3 files)
│   ├── PromptCrudTest.php (6 tests)
│   ├── PromptVisibilityTest.php (4 tests)
│   └── PromptVersioningTest.php (4 tests)
│
├── Sharing/ (2 files)
│   ├── AccesoCompartidoTest.php (6 tests)
│   └── CollaborationTest.php (3 tests)
│
├── Comments/ (1 file)
│   └── ComentarioTest.php (5 tests)
│
├── Ratings/ (1 file)
│   └── CalificacionTest.php (5 tests)
│
├── Tags/ (1 file)
│   └── EtiquetaTest.php (4 tests)
│
├── Admin/ (2 files)
│   ├── UserManagementTest.php (5 tests)
│   └── ConfigurationTest.php (3 tests)
│
└── Calendar/ (1 file)
    └── EventoTest.php (5 tests)
```

---

## 🎯 Tareas por Fase

### Tarea 22: Estructura Base y Setup de Testing (CRÍTICO)

**Objetivo:** Preparar infraestructura de testing

**Subtareas:**
- [ ] Verificar estructura existente en `tests/` 
- [ ] Crear directorios para tests
  - [ ] `tests/Unit/Models/`
  - [ ] `tests/Unit/Services/`
  - [ ] `tests/Feature/Prompts/`
  - [ ] `tests/Feature/Sharing/`
  - [ ] `tests/Feature/Comments/`
  - [ ] `tests/Feature/Ratings/`
  - [ ] `tests/Feature/Tags/`
  - [ ] `tests/Feature/Admin/`
  - [ ] `tests/Feature/Calendar/`
- [ ] Configurar `phpunit.xml` (DB testing)
- [ ] Crear factories para modelos
- [ ] Commit: "test: setup infrastructure for testing suite"

**Razón:** Fundación sólida para suite de testing

---

### Tarea 23: Unit Tests de Modelos (ALTA)

**Objetivo:** Validar lógica de modelos y relaciones

**Tests a Implementar:**

#### UserTest.php
```php
test_user_has_role_relationship()
test_user_es_admin_returns_true_for_admin()
test_user_es_admin_returns_false_for_user()
test_user_tiene_permiso_checks_role_permissions()
test_user_puede_editar_own_prompt()
test_user_puede_editar_shared_prompt_as_editor()
test_user_cannot_edit_others_prompt()
```

#### PromptTest.php
```php
test_prompt_belongs_to_user()
test_prompt_has_many_versiones()
test_prompt_has_many_etiquetas()
test_prompt_recalcular_promedio()
test_prompt_incrementar_vistas()
test_prompt_es_visible_para_owner()
test_prompt_es_visible_para_public()
test_prompt_es_visible_para_shared_user()
test_prompt_not_visible_for_private()
```

#### Otros Modelos
- RoleTest.php (3 tests)
- VersionTest.php (2 tests)
- ComentarioTest.php (4 tests)
- CalificacionTest.php (3 tests)
- EtiquetaTest.php (1 test)
- AccesoCompartidoTest.php (2 tests)

**Razón:** Validación de modelos y relaciones fundamentales

---

### Tarea 24: Feature Tests - CRUD de Prompts (CRÍTICO)

**Objetivo:** Validar creación, lectura, actualización y eliminación de prompts

**Tests a Implementar:**

```php
PromptCrudTest.php:
├── test_user_can_create_prompt()
├── test_user_can_view_own_prompts()
├── test_user_can_update_own_prompt()
├── test_user_can_delete_own_prompt()
├── test_user_cannot_delete_others_prompt()
└── test_admin_can_delete_any_prompt()
```

**Validaciones:**
- CreatePromptRequest validations
- HTTP responses (200, 403, 404)
- Database persistence
- Authorization checks

**Razón:** Funcionalidad core - creación/edición/eliminación

---

### Tarea 25: Feature Tests - Visibilidad de Prompts (CRÍTICO)

**Objetivo:** Validar seguridad de acceso a prompts

**Tests a Implementar:**

```php
PromptVisibilityTest.php:
├── test_public_prompts_visible_to_all()
├── test_private_prompts_hidden_from_others()
├── test_link_prompts_accessible_with_token()
└── test_shared_prompts_visible_to_shared_users()
```

**Validaciones:**
- PromptPolicy checks
- Authorization middleware
- Database queries with can()
- Token-based access

**Razón:** Seguridad de acceso crítica

---

### Tarea 26: Feature Tests - Versionado de Prompts (ALTA)

**Objetivo:** Validar sistema de versionado

**Tests a Implementar:**

```php
PromptVersioningTest.php:
├── test_editing_prompt_creates_new_version()
├── test_user_can_view_version_history()
├── test_user_can_restore_previous_version()
└── test_version_comparison_works()
```

**Validaciones:**
- Incremento automático de numero_version
- Relación prompt->versiones
- Restauración de versiones previas
- Comparación de cambios

**Razón:** Funcionalidad crítica de versionado

---

### Tarea 27: Feature Tests - Compartir y Colaboración (ALTA)

**Objetivo:** Validar sistema de compartir y niveles de acceso

**Tests a Implementar:**

```php
AccesoCompartidoTest.php:
├── test_owner_can_share_prompt()
├── test_share_with_lector_level()
├── test_share_with_comentador_level()
├── test_share_with_editor_level()
├── test_owner_can_revoke_access()
└── test_shared_user_receives_notification()

CollaborationTest.php:
├── test_editor_can_edit_shared_prompt()
├── test_comentador_can_comment_not_edit()
└── test_lector_can_only_view()
```

**Validaciones:**
- Niveles de acceso (AccesoCompartido)
- Autorización por nivel
- Notificaciones
- Revocación de acceso

**Razón:** Funcionalidad core de compartir

---

### Tarea 28: Feature Tests - Comentarios (MEDIA)

**Objetivo:** Validar sistema de comentarios anidados

**Tests a Implementar:**

```php
ComentarioTest.php:
├── test_user_can_comment_on_public_prompt()
├── test_user_can_reply_to_comment()
├── test_owner_can_delete_comment()
├── test_user_can_delete_own_comment()
└── test_nested_comments_display_correctly()
```

**Validaciones:**
- Relaciones parent/replies
- Autorización para eliminar
- Anidamiento de comentarios

**Razón:** Funcionalidad de colaboración

---

### Tarea 29: Feature Tests - Calificaciones (MEDIA)

**Objetivo:** Validar sistema de rating y promedio

**Tests a Implementar:**

```php
CalificacionTest.php:
├── test_user_can_rate_prompt()
├── test_user_can_update_rating()
├── test_user_cannot_rate_twice()
├── test_prompt_average_updates_on_rating()
└── test_rating_range_validation()
```

**Validaciones:**
- Rango 1-5 estrellas
- UpdateOrCreate automático
- Cálculo de promedio
- CalificacionService integration

**Razón:** Funcionalidad de valoración

---

### Tarea 30: Feature Tests - Etiquetas (MEDIA)

**Objetivo:** Validar sistema de etiquetas y filtrado

**Tests a Implementar:**

```php
EtiquetaTest.php:
├── test_user_can_add_tags_to_prompt()
├── test_user_can_remove_tags_from_prompt()
├── test_admin_can_create_global_tags()
└── test_filter_prompts_by_tag()
```

**Validaciones:**
- Relación many-to-many
- Búsqueda por etiqueta
- Permisos de creación

**Razón:** Funcionalidad de categorización

---

### Tarea 31: Feature Tests - Administración de Usuarios (MEDIA)

**Objetivo:** Validar gestión administrativa de usuarios

**Tests a Implementar:**

```php
UserManagementTest.php:
├── test_admin_can_list_users()
├── test_admin_can_create_user()
├── test_admin_can_deactivate_user()
├── test_admin_can_change_user_role()
└── test_non_admin_cannot_access_user_management()
```

**Validaciones:**
- Policies de administración
- Middleware admin
- Autorización por rol

**Razón:** Seguridad - solo admins pueden gestionar usuarios

---

### Tarea 32: Feature Tests - Configuración de Sistema (MEDIA)

**Objetivo:** Validar gestión de configuración

**Tests a Implementar:**

```php
ConfigurationTest.php:
├── test_admin_can_view_settings()
├── test_admin_can_update_settings()
└── test_non_admin_cannot_access_settings()
```

**Validaciones:**
- ConfigurationService integration
- Persistencia en app_settings
- Autorización admin

**Razón:** Seguridad - solo admins pueden configurar

---

### Tarea 33: Feature Tests - Calendario de Eventos (BAJA)

**Objetivo:** Validar gestión de eventos

**Tests a Implementar:**

```php
EventoTest.php:
├── test_user_can_create_event()
├── test_user_can_view_own_events()
├── test_user_can_update_event()
├── test_user_can_delete_event()
└── test_user_can_mark_event_complete()
```

**Validaciones:**
- Relaciones usuario-evento
- Estados (completado/pendiente)
- Autorización

**Razón:** Funcionalidad secundaria

---

### Tarea 34: Unit Tests de Servicios (ALTA)

**Objetivo:** Validar lógica de negocio en servicios

**Tests a Implementar:**

#### CalificacionService
```php
test_calificar_creates_or_updates_rating()
test_obtener_calificacion_returns_user_rating()
```

#### CompartirService
```php
test_compartir_creates_acceso_compartido()
test_compartir_por_email_sends_notification()
test_revocar_access_removes_record()
```

#### PromptService
```php
test_crear_prompt_validates_input()
test_actualizar_prompt_creates_version()
test_eliminar_prompt_soft_delete()
```

#### BackupService + ConfigurationService
```php
test_create_backup_generates_file()
test_list_backups_returns_files()
test_get_settings_returns_app_settings()
test_update_settings_persists_changes()
```

**Razón:** Validación de lógica de negocio

---

### Tarea 35: Validación Final y Cobertura (CRÍTICO)

**Objetivo:** Asegurar calidad y cobertura

**Subtareas:**
- [ ] Ejecutar todos los tests: `./vendor/bin/phpunit`
- [ ] Generar coverage report
- [ ] Validar cobertura >80%
- [ ] Validar 0 warnings/notices
- [ ] Documentar resultados en `docs/test-results.md`
- [ ] Crear CI/CD pipeline (GitHub Actions)
- [ ] Commit: "test: implementación completa de suite de testing integral"

**Métricas de Éxito:**
- 95+ tests implementados
- >80% code coverage
- Todas las funcionalidades críticas cubierta
- 0 failing tests

**Razón:** Garantía de calidad y confianza

---

## 📊 Matriz de Cobertura de Tests

| Módulo | Unit | Feature | Métodos Cubiertos |
|--------|------|---------|-------------------|
| **User** | ✅ | ✅ | 7+ |
| **Prompt** | ✅ | ✅ | 14+ |
| **Version** | ✅ | ✅ | 4+ |
| **AccesoCompartido** | ✅ | ✅ | 8+ |
| **Comentario** | ✅ | ✅ | 5+ |
| **Calificacion** | ✅ | ✅ | 5+ |
| **Etiqueta** | ✅ | ✅ | 4+ |
| **Evento** | ✅ | ✅ | 5+ |
| **CalificacionService** | ✅ | N/A | 2+ |
| **CompartirService** | ✅ | N/A | 3+ |
| **PromptService** | ✅ | N/A | 3+ |
| **ConfigurationService** | ✅ | N/A | 2+ |
| **BackupService** | ✅ | N/A | 2+ |

---

## 🔗 Arquitectura de Tests

```
PromptVault/
├── tests/
│   ├── Feature/
│   │   ├── Auth/                    (existentes)
│   │   ├── Prompts/
│   │   │   ├── PromptCrudTest.php
│   │   │   ├── PromptVisibilityTest.php
│   │   │   └── PromptVersioningTest.php
│   │   ├── Sharing/
│   │   │   ├── AccesoCompartidoTest.php
│   │   │   └── CollaborationTest.php
│   │   ├── Comments/
│   │   │   └── ComentarioTest.php
│   │   ├── Ratings/
│   │   │   └── CalificacionTest.php
│   │   ├── Tags/
│   │   │   └── EtiquetaTest.php
│   │   ├── Admin/
│   │   │   ├── UserManagementTest.php
│   │   │   └── ConfigurationTest.php
│   │   └── Calendar/
│   │       └── EventoTest.php
│   │
│   ├── Unit/
│   │   ├── ExampleTest.php          (existente)
│   │   ├── Models/
│   │   │   ├── UserTest.php
│   │   │   ├── PromptTest.php
│   │   │   ├── RoleTest.php
│   │   │   ├── VersionTest.php
│   │   │   ├── ComentarioTest.php
│   │   │   ├── CalificacionTest.php
│   │   │   ├── EtiquetaTest.php
│   │   │   └── AccesoCompartidoTest.php
│   │   └── Services/
│   │       ├── CalificacionServiceTest.php
│   │       ├── CompartirServiceTest.php
│   │       ├── PromptServiceTest.php
│   │       ├── ConfigurationServiceTest.php
│   │       └── BackupServiceTest.php
│   │
│   ├── TestCase.php                 (configuración base)
│   └── Fixtures/                    (data de prueba)
│
├── phpunit.xml                       (configuración)
└── .env.testing                      (variables de testing)
```

---

## ⚙️ Configuración de Entorno

### phpunit.xml
```xml
<!-- Incluir testing database separada o in-memory SQLite -->
<!-- Configurar variables de APP_DEBUG=false, MAIL_DRIVER=log -->
<!-- Incluir coverage report paths -->
```

### .env.testing
```bash
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
MAIL_DRIVER=log
APP_DEBUG=false
```

### Factories Necesarias
- UserFactory (roles aleatorios)
- PromptFactory (visibilidades)
- RoleFactory (user_types)
- VersionFactory
- ComentarioFactory
- CalificacionFactory
- EtiquetaFactory
- AccesoCompartidoFactory
- EventoFactory

---

## 📈 Métricas de Éxito

| Métrica | Target |
|---------|--------|
| Tests Implementados | 95+ |
| Code Coverage | >80% |
| Failing Tests | 0 |
| Execution Time | <60 sec |
| CI/CD Status | ✅ Passing |

---

## 🚀 Estrategia de Implementación

### Orden Recomendado:
1. **Tarea 22** - Setup (1 día)
2. **Tarea 23** - Unit Models (1-2 días)
3. **Tarea 24-26** - CRUD & Versioning (2-3 días)
4. **Tarea 27** - Sharing (1-2 días)
5. **Tarea 28-33** - Features restantes (2-3 días)
6. **Tarea 34** - Services (1-2 días)
7. **Tarea 35** - Validación final (1 día)

**Tiempo Total Estimado:** 10-15 días

---

## 📝 Convenciones de Testing

### Nombres de Tests
```php
// ✅ Correcto
test_user_can_create_prompt()
test_user_cannot_delete_others_prompt()
test_prompt_average_updates_on_rating()

// ❌ Evitar
testCreatePrompt()
test_create()
testPrompts()
```

### Estructura AAA (Arrange-Act-Assert)
```php
public function test_user_can_create_prompt()
{
    // Arrange
    $user = User::factory()->create();
    $data = ['title' => 'Test', 'content' => 'Content'];
    
    // Act
    $response = $this->actingAs($user)->post('/prompts', $data);
    
    // Assert
    $response->assertStatus(201);
    $this->assertDatabaseHas('prompts', $data);
}
```

### Setup/Teardown Automático
```php
// En TestCase base
protected function setUp(): void
{
    parent::setUp();
    $this->seed(RoleSeeder::class);
}
```

---

## 🔄 Integración Continua

### GitHub Actions Workflow
```yaml
name: Tests
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - run: composer install
      - run: ./vendor/bin/phpunit
      - run: ./vendor/bin/phpunit --coverage-html coverage
```

---

## 📚 Referencias

- [Laravel Testing Documentation](https://laravel.com/docs/10.x/testing)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Best Practices for Testing Laravel Applications](https://laravel.com/docs/10.x/testing#best-practices)

---

**Última Actualización:** 28 de enero de 2026  
**Próximo Paso:** Iniciar Tarea 22 - Setup de Testing
