# 02 - Entidades y Relaciones

**PromptVault - Modelo de Datos**

---

## Diagrama de Relaciones

```
┌─────────────┐
│   ROLES     │
│  (4 roles)  │
└──────┬──────┘
       │ 1:N
       ▼
┌─────────────┐         ┌──────────────┐
│   USERS     │────────▶│  SESIONES    │
│ (12 users)  │   1:1   │  _PROMPTS    │
└──────┬──────┘         └──────────────┘
       │ 1:N
       ▼
┌─────────────┐
│   PROMPTS   │◀────────┐
│ (Principal) │         │
└──────┬──────┘         │
       │                │
       ├─────────────┐  │
       │ 1:N         │  │
       ▼             ▼  │ N:1
┌─────────────┐ ┌──────────────┐
│  VERSIONES  │ │  CATEGORIAS  │
│             │ │              │
└─────────────┘ └──────────────┘

┌─────────────┐
│   PROMPTS   │
└──────┬──────┘
       │ 1:N
       ├─────────────┬─────────────┐
       ▼             ▼             ▼
┌─────────────┐ ┌──────────────┐ ┌──────────────┐
│ COMPARTIDOS │ │ ACTIVIDADES  │ │  ETIQUETAS   │
│             │ │              │ │    (N:M)     │
└─────────────┘ └──────────────┘ └──────────────┘
```

---

## Relaciones Detalladas

### 1. Usuario → Prompt (1:N)
Un usuario puede crear múltiples prompts, pero cada prompt pertenece a un solo usuario.

**Implementación:**
- `prompts.user_id` → `users.id`
- Modelo: `User::hasMany(Prompt::class)`
- Inversa: `Prompt::belongsTo(User::class)`

---

### 2. Categoría → Prompt (1:N)
Una categoría puede contener múltiples prompts, pero cada prompt tiene una sola categoría.

**Implementación:**
- `prompts.categoria_id` → `categorias.id` (nullable)
- Modelo: `Categoria::hasMany(Prompt::class)`
- Inversa: `Prompt::belongsTo(Categoria::class)`

---

### 3. Prompt ↔ Etiqueta (N:M)
Un prompt puede tener múltiples etiquetas y una etiqueta puede estar en múltiples prompts.

**Implementación:**
- Tabla pivot: `etiqueta_prompt`
- Modelo: `Prompt::belongsToMany(Etiqueta::class)`
- Inversa: `Etiqueta::belongsToMany(Prompt::class)`

---

### 4. Prompt → Versión (1:N)
Un prompt puede tener múltiples versiones en su historial.

**Implementación:**
- `versiones.prompt_id` → `prompts.id`
- Modelo: `Prompt::hasMany(Version::class)`
- Inversa: `Version::belongsTo(Prompt::class)`

**Lógica:**
- Cada modificación del contenido crea una nueva versión
- Se guarda el contenido anterior y el motivo del cambio
- El campo `prompts.version_actual` indica la versión vigente

---

### 5. Prompt → Compartido (1:N)
Un prompt puede ser compartido con múltiples personas.

**Implementación:**
- `compartidos.prompt_id` → `prompts.id`
- Modelo: `Prompt::hasMany(Compartido::class)`
- Inversa: `Compartido::belongsTo(Prompt::class)`

**Tipos de Acceso:**
- **solo_lectura**: Solo visualizar
- **puede_copiar**: Visualizar y copiar contenido
- **puede_editar**: Crear nuevas versiones (requiere autenticación)

---

### 6. Prompt → Actividad (1:N)
Un prompt genera múltiples registros de actividad en su ciclo de vida.

**Implementación:**
- `actividades.prompt_id` → `prompts.id`
- Modelo: `Prompt::hasMany(Actividad::class)`
- Inversa: `Actividad::belongsTo(Prompt::class)`

**Eventos Registrados:**
- Creación, edición, eliminación
- Uso, compartido
- Marcado como favorito
- Restauración de versiones

---

### 7. Usuario → Actividad (1:N)
Un usuario genera múltiples actividades en el sistema.

**Implementación:**
- `actividades.user_id` → `users.id`
- Modelo: `User::hasMany(Actividad::class)`
- Inversa: `Actividad::belongsTo(User::class)`

---

### 8. Usuario → Sesión Prompts (1:1)
Cada usuario tiene una única sesión de preferencias.

**Implementación:**
- `sesiones_prompts.user_id` → `users.id` (unique)
- Modelo: `User::hasOne(SesionPrompt::class)`
- Inversa: `SesionPrompt::belongsTo(User::class)`

---

### 9. Rol ↔ Permiso (N:M)
Un rol tiene múltiples permisos y un permiso puede estar en múltiples roles.

**Implementación:**
- Tabla pivot: `role_permiso`
- Modelo: `Role::belongsToMany(Permiso::class)`
- Inversa: `Permiso::belongsToMany(Role::class)`

---

### 10. Usuario → Rol (N:1)
Múltiples usuarios pueden tener el mismo rol.

**Implementación:**
- `users.role_id` → `roles.id`
- Modelo: `User::belongsTo(Role::class)`
- Inversa: `Role::hasMany(User::class)`

---

## Cardinalidades Resumen

| Relación | Cardinalidad | Obligatoria |
|----------|--------------|-------------|
| User → Prompt | 1:N | No (0 o más) |
| Categoria → Prompt | 1:N | No (0 o más) |
| Prompt ↔ Etiqueta | N:M | No (0 o más) |
| Prompt → Version | 1:N | Sí (mínimo 1) |
| Prompt → Compartido | 1:N | No (0 o más) |
| Prompt → Actividad | 1:N | Sí (mínimo 1) |
| User → Actividad | 1:N | Sí (al crear prompt) |
| User → SesionPrompt | 1:1 | No (se crea al usar) |
| Role ↔ Permiso | N:M | Sí (role debe tener permisos) |
| User → Role | N:1 | Sí (user debe tener rol) |

---

## Integridad Referencial

### ON DELETE CASCADE
Cuando se elimina el padre, se eliminan los hijos:
- Prompt → Versiones
- Prompt → Compartidos
- Prompt → Actividades
- User → Prompts
- User → Actividades
- User → SesionPrompts

### ON DELETE SET NULL
Cuando se elimina el padre, el campo FK se pone NULL:
- Categoria → Prompts (permite prompts sin categoría)

### ON DELETE RESTRICT
No permite eliminar el padre si tiene hijos:
- Role → Users (debe reasignar users antes)

---

**Total de Relaciones:** 10 relaciones principales implementadas
