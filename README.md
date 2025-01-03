# Ekylibria WordPress Project

Proyecto WordPress personalizado con ACF, Elementor y WPML para sitio multilingüe.

## Requisitos

### Servidor
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Apache/Nginx

### Desarrollo
- Node.js y npm
- Gulp CLI (`npm install -g gulp-cli`)
- Git

### Plugins Requeridos
- Advanced Custom Fields PRO
- Elementor PRO
- WPML (licencia válida)

## Instalación Inicial

### 1. Preparación Local
```bash
# Clonar repositorio
git clone https://github.com/tu-usuario/ekylibria.git
cd ekylibria

# Instalar dependencias
npm install
```

### 2. Base de Datos
- Crear nueva base de datos MySQL
- Copiar configuración:
  ```bash
  cp wp-config-sample.php wp-config.php
  ```
- Editar wp-config.php con credenciales
- Generar claves de seguridad desde:
  https://api.wordpress.org/secret-key/1.1/salt/
  ```php
  // Reemplazar estas líneas en wp-config.php con las generadas
  define('AUTH_KEY',         'claves-generadas');
  define('SECURE_AUTH_KEY',  'claves-generadas');
  define('LOGGED_IN_KEY',    'claves-generadas');
  define('NONCE_KEY',       'claves-generadas');
  define('AUTH_SALT',        'claves-generadas');
  define('SECURE_AUTH_SALT', 'claves-generadas');
  define('LOGGED_IN_SALT',   'claves-generadas');
  define('NONCE_SALT',      'claves-generadas');
  ```

### 3. Servidor Local
```bash
# Iniciar servidor de desarrollo
php -S localhost:8000 router.php
```

### 4. Instalación WordPress
- Visitar http://localhost:8000
- Completar instalación WordPress
- Activar plugins necesarios

## Desarrollo

### Estructura del Proyecto
```
proyecto/
├── wp-content/
│   ├── themes/ekylibria-theme/
│   ├── plugins/
│   └── uploads/
├── data/
│   ├── elementor/     # Exports de páginas
│   ├── acf/           # Exports de campos
│   └── wpml/          # Exports de traducciones
└── builds/            # Archivos de build
```

### Comandos Gulp

```bash
# Build completo (instalación inicial)
gulp build-full

# Build de actualización (solo wp-content)
gulp build-update
```

## Despliegue

### Build de Actualización
1. Generar build:
   ```bash
   gulp build-update
   ```
2. Se genera: `site-update-FECHA.zip`
3. Subir y descomprimir SOLO wp-content/

### Build Completo (Primera vez)
1. Generar build:
   ```bash
   gulp build-full
   ```
2. Se genera: `site-full-FECHA.zip`
3. Subir y descomprimir todo
4. Configurar wp-config.php

## Exports y Backups

### Elementor
- Exportar: Elementor > Herramientas
- Guardar en: data/elementor/
- Incluir fecha en nombre

### ACF
- Exportar: Custom Fields > Herramientas
- Guardar en: data/acf/
- Documentar campos exportados

### WPML
- Exportar: WPML > Traducción de cadenas
- Guardar en: data/wpml/
- Separar por idiomas

## Notas Importantes

### Seguridad
- No versionar wp-config.php
- Proteger archivos sensibles
- Mantener backups regulares

### Desarrollo
- Usar router.php para URLs locales
- Documentar cambios importantes
- Seguir estándares WordPress

### Producción
- Verificar permisos de archivos
- Probar en staging primero
- Mantener registro de builds
