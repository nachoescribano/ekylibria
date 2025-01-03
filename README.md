# Ekylibria WordPress Project

Este es un proyecto de WordPress personalizado que utiliza Advanced Custom Fields (ACF), Elementor y WPML para la construcción de páginas multilingües.

## Requisitos Previos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx) o PHP's built-in server
- Composer (opcional)
- Git
- Licencia válida de WPML

## Instalación

1. Clona el repositorio:
```bash
git clone https://github.com/tu-usuario/ekylibria.git
cd ekylibria
```

2. Configura la base de datos:
   - Crea una nueva base de datos MySQL para el proyecto
   - Copia el archivo de configuración de ejemplo:
   ```bash
   cp wp-config-sample.php wp-config.php
   ```
   - Edita `wp-config.php` y actualiza los siguientes valores:
     - `DB_NAME`: Nombre de tu base de datos
     - `DB_USER`: Usuario de MySQL
     - `DB_PASSWORD`: Contraseña de MySQL
     - `DB_HOST`: Host de la base de datos (normalmente 'localhost')

3. Inicia el servidor:
   ```bash
   # Usando el servidor integrado de PHP
   php -S localhost:8000
   ```
   O configura tu servidor web (Apache/Nginx) apuntando al directorio del proyecto

4. Completa la instalación:
   - Visita `http://localhost:8000` en tu navegador
   - Sigue el asistente de instalación de WordPress
   - Los plugins necesarios ya están incluidos en el repositorio

5. Configura WPML:
   - Activa WPML Multilingual CMS
   - Activa WPML String Translation
   - Sigue el asistente de configuración de WPML
   - Configura los idiomas que necesitas

## Desarrollo

- El tema personalizado se encuentra en `wp-content/themes/ekylibria-theme/`
- Los campos personalizados de ACF se pueden exportar/importar desde el panel de administración
- Las páginas se pueden construir usando Elementor desde el editor de WordPress
- Las traducciones se gestionan con WPML

## Plugins Incluidos

- Advanced Custom Fields (ACF)
- Elementor Page Builder
- WPML Multilingual CMS (requiere licencia)
- WPML String Translation (requiere licencia)

## Notas Importantes

- No subas al repositorio el archivo `wp-config.php` con tus credenciales
- La carpeta `wp-content/uploads/` está ignorada en git
- Para desarrollo local, se recomienda activar WP_DEBUG en wp-config.php:
  ```php
  define('WP_DEBUG', true);
  define('WP_DEBUG_LOG', true);
  define('WP_DEBUG_DISPLAY', false);
  ```
- Las claves de licencia de WPML no deben incluirse en el repositorio

## Soporte

Para reportar problemas o sugerir mejoras, por favor crea un issue en el repositorio. 