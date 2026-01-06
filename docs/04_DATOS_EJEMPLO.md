# 04 - Datos de Ejemplo

**PromptVault - Registros de Prueba**

---

## Resumen de Datos

| Tabla | Registros | Descripción |
|-------|-----------|-------------|
| users | 12 | 1 Admin, 1 Demo, 10 usuarios de diferentes áreas |
| roles | 4 | Admin, User, Collaborator, Guest |
| permisos | 40 | Permisos organizados por 9 módulos |
| categorias | 6 | Categorías temáticas con colores |
| etiquetas | 20 | Tags para clasificación |
| prompts | 10 | Prompts de ejemplo en español |
| versiones | 10 | Historial de cambios |
| compartidos | 10 | Prompts compartidos con tokens |
| actividades | 10 | Log de acciones |
| sesiones_prompts | 10 | Preferencias de usuarios |

---

## Usuarios de Prueba

### Administradores
```
Email: admin@promptvault.com
Password: password
Rol: Admin (control total)
```

### Usuario Demo
```
Email: user@promptvault.com
Password: password
Rol: User (usuario estándar)
```

### Usuarios por Área

| Nombre | Email | Rol | Área |
|--------|-------|-----|------|
| Carlos Martínez | carlos@dev.com | User | Desarrollo |
| Ana López | ana@escritora.com | User | Redacción |
| Pedro Sánchez | pedro@ingeniero.com | User | Ingeniería |
| María García | maria@marketing.com | User | Marketing |
| Luis Rodríguez | luis@arquitecto.com | User | Arquitectura |
| Carmen Torres | carmen@educadora.com | Collaborator | Educación |
| Jorge Ramírez | jorge@analista.com | User | Análisis |
| Laura Fernández | laura@disenadora.com | Collaborator | Diseño |
| Roberto Díaz | roberto@consultor.com | User | Consultoría |
| Isabel Moreno | isabel@investigadora.com | User | Investigación |

---

## Categorías Predefinidas

| ID | Nombre | Color | Descripción |
|----|--------|-------|-------------|
| 1 | Programación | #3B82F6 | Desarrollo de software, código |
| 2 | Redacción | #10B981 | Escritura creativa, documentos |
| 3 | Análisis de datos | #F59E0B | Estadística, visualización |
| 4 | Marketing | #EC4899 | Estrategias, contenido |
| 5 | Educación | #8B5CF6 | Enseñanza, aprendizaje |
| 6 | Diseño | #EF4444 | UI/UX, creatividad visual |

---

## Etiquetas Disponibles

**Tecnología:** ChatGPT, Claude, Gemini, Copilot

**Lenguajes:** Python, JavaScript, PHP, Laravel, React, Vue, SQL

**Acciones:** API, Testing, Debug, Optimización

**Marketing:** SEO, Social Media, Email, Blog

**Educación:** Tutorial

---

## Prompts de Ejemplo

### 1. Revisar código Python
- **Usuario:** Carlos Martínez
- **Categoría:** Programación
- **IA:** ChatGPT
- **Contenido:** Analiza código y sugiere mejoras en rendimiento y legibilidad
- **Etiquetas:** Python, ChatGPT, Debug
- **Estado:** Favorito, 5 usos

### 2. Redactar informe técnico
- **Usuario:** Ana López
- **Categoría:** Redacción
- **IA:** Claude
- **Contenido:** Estructura para informes técnicos profesionales
- **Estado:** Público, 12 usos

### 3. Crear API REST Laravel
- **Usuario:** Pedro Sánchez
- **Categoría:** Programación
- **IA:** ChatGPT
- **Contenido:** Genera código API con autenticación JWT
- **Versiones:** 2 (actualizado a Laravel 11 + Sanctum)
- **Estado:** Favorito, 8 usos

### 4. Estrategia redes sociales
- **Usuario:** María García
- **Categoría:** Marketing
- **IA:** Gemini
- **Contenido:** Planificación de contenido con calendario
- **Estado:** Público, 15 usos

### 5. Optimizar consultas SQL
- **Usuario:** Carlos Martínez
- **Categoría:** Programación
- **IA:** Claude
- **Contenido:** Revisión y optimización de consultas SQL
- **Etiquetas:** SQL, Optimización
- **Estado:** 3 usos

### 6. Manual de usuario
- **Usuario:** Ana López
- **Categoría:** Redacción
- **IA:** ChatGPT
- **Contenido:** Documentación técnica paso a paso
- **Estado:** Favorito, 7 usos

### 7. Diseño de interfaz web
- **Usuario:** Jorge Ramírez
- **Categoría:** Diseño
- **IA:** Gemini
- **Contenido:** Wireframes y mockups UI/UX
- **Estado:** 4 usos

### 8. Plan de clase interactivo
- **Usuario:** Carmen Torres (Collaborator)
- **Categoría:** Educación
- **IA:** Claude
- **Contenido:** Plan educativo de 45 minutos
- **Estado:** Público, 10 usos

### 9. Análisis de datos ventas
- **Usuario:** Roberto Díaz
- **Categoría:** Análisis de datos
- **IA:** ChatGPT
- **Contenido:** Análisis estadístico con insights
- **Estado:** 6 usos

### 10. Tests unitarios automáticos
- **Usuario:** Pedro Sánchez
- **Categoría:** Programación
- **IA:** Claude
- **Contenido:** Generación de tests PHPUnit
- **Estado:** Favorito, 9 usos

---

## Compartidos Configurados

### Compartidos Internos (5)
- Prompt #2 → pedro@ingeniero.com (puede_editar)
- Prompt #4 → laura@disenadora.com (puede_copiar)
- Prompt #1 → ana@escritora.com (puede_editar)
- Prompt #6 → jorge@analista.com (puede_copiar)
- Prompt #10 → isabel@investigadora.com (puede_editar)

### Compartidos Externos con Token (5)
- Prompt #8 → carlos@dev.com (solo_lectura, expira en 30 días)
- Prompt #3 → cliente@empresa.com (solo_lectura, expira en 7 días)
- Prompt #7 → freelance@design.com (solo_lectura, expira en 15 días)

---

## Actividades Registradas

**Tipos de Acciones:**
- Creación de prompts (10 registros)
- Ediciones y nuevas versiones (2 registros)
- Marcado como favorito (2 registros)
- Uso/Copiado (2 registros)
- Compartido (2 registros)

**Usuarios más Activos:**
1. Carlos Martínez (3 acciones)
2. Ana López (2 acciones)
3. Pedro Sánchez (2 acciones)

---

## Sesiones Persistentes

Cada usuario tiene configuradas:
- **Vista preferida:** Grid o Lista
- **Orden:** Reciente, Título, Uso, Modificación
- **Filtros activos:** Por categoría, IA, favoritos
- **Búsquedas recientes:** 3 búsquedas por usuario

---

**Fecha de Generación:** 6 de enero de 2026  
**Total de Registros:** 132 registros distribuidos en 10 tablas
