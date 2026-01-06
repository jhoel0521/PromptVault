# 05 - Credenciales y Comandos

**PromptVault - Referencia Rápida**

---

## Credenciales del Sistema

### Base de Datos MySQL
```
Host: 127.0.0.1
Puerto: 3306
Base de Datos: promptvault
Usuario: root
Contraseña: (sin contraseña)
```

### Usuarios de Aplicación

**Administrador:**
```
Email: admin@promptvault.com
Password: password
Rol: Admin
```

**Usuario Demo:**
```
Email: user@promptvault.com
Password: password
Rol: User
```

---

## Comandos Laravel Esenciales

### Migraciones
```bash
# Ejecutar migraciones
php artisan migrate

# Revertir última migración
php artisan migrate:rollback

# Recrear BD desde cero
php artisan migrate:fresh

# Recrear BD + seeders
php artisan migrate:fresh --seed

# Ver estado de migraciones
php artisan migrate:status
```

### Seeders
```bash
# Ejecutar todos los seeders
php artisan db:seed

# Ejecutar un seeder específico
php artisan db:seed --class=PromptSeeder
```

### Caché y Optimización
```bash
# Limpiar caché de configuración
php artisan config:clear

# Limpiar caché de aplicación
php artisan cache:clear

# Limpiar caché de vistas
php artisan view:clear

# Limpiar caché de rutas
php artisan route:clear

# Limpiar todo
php artisan optimize:clear
```

### Generadores
```bash
# Crear modelo
php artisan make:model NombreModelo

# Crear migración
php artisan make:migration create_tabla_table

# Crear controlador
php artisan make:controller NombreController

# Crear seeder
php artisan make:seeder NombreSeeder

# Crear policy
php artisan make:policy NombrePolicy
```

### Rutas y Testing
```bash
# Listar rutas
php artisan route:list

# Listar rutas sin vendor
php artisan route:list --except-vendor

# Ejecutar tests
php artisan test
```

### Servidor de Desarrollo
```bash
# Iniciar servidor
php artisan serve

# Servidor en puerto específico
php artisan serve --port=8080
```

---

## Comandos MySQL Útiles

### Acceso a MySQL
```bash
# Entrar a MySQL
mysql -u root

# Entrar a BD específica
mysql -u root promptvault

# Ejecutar comando directo
mysql -u root -e "SHOW DATABASES;"
```

### Consultas Rápidas
```bash
# Ver todas las tablas
mysql -u root promptvault -e "SHOW TABLES;"

# Describir estructura de tabla
mysql -u root promptvault -e "DESCRIBE prompts;"

# Contar registros
mysql -u root promptvault -e "SELECT COUNT(*) FROM users;"

# Ver últimos registros
mysql -u root promptvault -e "SELECT * FROM prompts ORDER BY id DESC LIMIT 5;"
```

### Backup y Restore
```bash
# Exportar BD completa
mysqldump -u root promptvault > backup.sql

# Importar BD
mysql -u root promptvault < backup.sql

# Exportar solo estructura
mysqldump -u root --no-data promptvault > estructura.sql

# Exportar solo datos
mysqldump -u root --no-create-info promptvault > datos.sql
```

---

## Comandos Git

```bash
# Ver estado
git status

# Ver cambios
git diff

# Agregar todos los cambios
git add .

# Commit
git commit -m "Mensaje"

# Ver historial
git log --oneline

# Ver ramas
git branch
```

---

## Comandos Composer

```bash
# Instalar dependencias
composer install

# Actualizar dependencias
composer update

# Instalar paquete
composer require vendor/package

# Autoload
composer dump-autoload
```

---

## Comandos NPM

```bash
# Instalar dependencias
npm install

# Compilar assets (desarrollo)
npm run dev

# Compilar assets (producción)
npm run build

# Watch mode
npm run watch
```

---

## Verificación del Sistema

### Comprobar Conexión BD
```bash
php artisan tinker
>>> DB::connection()->getPdo();
>>> DB::table('users')->count();
>>> exit
```

### Ver Configuración
```bash
# Ver configuración de BD
php artisan tinker
>>> config('database.connections.mysql');
>>> exit
```

### Verificar Tablas
```bash
# Contar registros en todas las tablas
mysql -u root promptvault -e "
SELECT 'users' as tabla, COUNT(*) as total FROM users
UNION ALL SELECT 'prompts', COUNT(*) FROM prompts
UNION ALL SELECT 'categorias', COUNT(*) FROM categorias
UNION ALL SELECT 'versiones', COUNT(*) FROM versiones;"
```

---

## Solución de Problemas Comunes

### Error: "Access denied for user"
```bash
# Verificar usuario MySQL
mysql -u root -e "SELECT user FROM mysql.user;"

# Resetear contraseña root (si es necesario)
# En phpMyAdmin o HeidiSQL
```

### Error: "Database doesn't exist"
```bash
# Crear base de datos
mysql -u root -e "CREATE DATABASE promptvault CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Error: "Class not found"
```bash
# Regenerar autoload
composer dump-autoload

# Limpiar caché
php artisan optimize:clear
```

### Error: "SQLSTATE[HY000] [2002]"
```bash
# Verificar que MySQL esté corriendo
# En Laragon: Iniciar servicios

# Verificar puerto
netstat -an | findstr :3306
```

---

## URLs del Sistema

```
Aplicación: http://localhost/PromptVault/public
o
http://127.0.0.1:8000 (con php artisan serve)

Login: /login
Register: /register
Dashboard: /dashboard
Prompts: /prompts
```

---

**Última Actualización:** 6 de enero de 2026
