# Directorio de Datos Exportados

Este directorio contiene los exports de configuración y contenido del sitio.

## Estructura

```
data/
├── elementor/     # Exports de páginas y configuraciones de Elementor
├── acf/           # Exports de campos personalizados de ACF
└── wpml/          # Exports de traducciones de WPML
```

## Uso

### Elementor Exports
1. Para exportar:
   - Ve a Elementor > Herramientas > Exportar/Importar
   - Usa "Export Kit" para una exportación completa
   - Guarda el archivo JSON en la carpeta `elementor/`
   - Incluye una fecha en el nombre del archivo (ej: `homepage-2024-01-20.json`)

2. Para importar:
   - Ve a Elementor > Herramientas > Importar
   - Selecciona el archivo JSON deseado
   - Revisa las opciones de importación antes de proceder

### ACF Exports
1. Para exportar:
   - Ve a Custom Fields > Herramientas
   - Selecciona los grupos de campos a exportar
   - Guarda el archivo JSON en la carpeta `acf/`
   - Incluye una descripción en el nombre (ej: `home-fields.json`)

2. Para importar:
   - Ve a Custom Fields > Herramientas
   - Selecciona el archivo JSON a importar
   - Confirma los campos a importar

### WPML Exports
1. Para exportar traducciones:
   - Ve a WPML > Traducción de cadenas > Exportar/Importar
   - Selecciona los idiomas a exportar
   - Guarda el archivo en la carpeta `wpml/`
   - Incluye los idiomas en el nombre (ej: `strings-es-en-2024-01-20.xml`)

2. Para importar traducciones:
   - Ve a WPML > Traducción de cadenas > Exportar/Importar
   - Selecciona el archivo a importar
   - Confirma las traducciones a importar

## Notas
- Mantén un registro de cambios en los archivos exportados
- Asegúrate de que las imágenes y medios estén disponibles en el servidor de destino
- Verifica las versiones de plugins antes de importar
- Las traducciones de WPML deben exportarse/importarse por separado para cada idioma
- No incluyas claves de licencia de WPML en los archivos exportados 