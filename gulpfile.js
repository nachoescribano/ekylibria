const gulp = require('gulp');
const zip = require('gulp-zip');
const clean = require('gulp-clean');
const replace = require('gulp-replace');
const dateFormat = require('dateformat');
const fs = require('fs');
const log = require('fancy-log');
const colors = require('ansi-colors');
const https = require('https');
const decompress = require('gulp-decompress');

const config = {
  buildDir: './build',
  tempDir: './temp',
  buildsDir: './builds',
  zipName: (type) => `site-${type}-${dateFormat(new Date(), "yyyy-mm-dd-HHMMss")}.zip`,
  wpVersion: '6.7.1', // Especifica la versión de WordPress
  
  // Configuración para build de actualización
  updateIncludes: [
    'wp-content/**/*',
  ],
  
  // Configuración para build inicial
  fullIncludes: [
    'wp-admin/**/*',
    'wp-includes/**/*',
    'wp-content/**/*',
    'index.php',
    'wp-*.php',
    '.htaccess',
    'wp-config-sample.php'
  ],
  
  // Exclusiones comunes
  excludes: [
    '!node_modules/**',
    '!build/**',
    '!gulpfile.js',
    '!package.json',
    '!package-lock.json',
    '!.git/**',
    '!wp-config.php',
    '!.env',
    '!README.md',
    '!**/*.log'
  ]
};

// Limpiar directorios temporales
gulp.task('clean', () => {
  return gulp.src([config.buildDir, config.tempDir], { allowEmpty: true })
    .pipe(clean({ force: true }));
});

// Crear directorios necesarios
gulp.task('init', (done) => {
  // Creamos buildDir y tempDir si no existen
  [config.buildDir, config.tempDir].forEach(dir => {
    if (!fs.existsSync(dir)) {
      fs.mkdirSync(dir, { recursive: true });
      log(colors.green(`Directorio creado: ${dir}`));
    }
  });
  
  // Creamos buildsDir si no existe (pero no lo limpiamos)
  if (!fs.existsSync(config.buildsDir)) {
    fs.mkdirSync(config.buildsDir, { recursive: true });
    log(colors.green(`Directorio de builds creado: ${config.buildsDir}`));
  }
  
  done();
});

// Descargar y descomprimir WordPress
gulp.task('download-wp', (done) => {
  const wpUrl = `https://wordpress.org/wordpress-${config.wpVersion}.zip`;
  const filePath = `${config.tempDir}/wordpress.zip`;
  
  log(colors.blue(`Descargando WordPress ${config.wpVersion}...`));
  
  const file = fs.createWriteStream(filePath);
  https.get(wpUrl, (response) => {
    if (response.statusCode !== 200) {
      log.error(colors.red(`Error descargando WordPress: ${response.statusCode}`));
      done(new Error(`HTTP Status Code: ${response.statusCode}`));
      return;
    }
    
    response.pipe(file);
    
    file.on('finish', () => {
      file.close();
      log(colors.green('WordPress descargado correctamente'));
      
      // Descomprimir WordPress
      gulp.src(`${config.tempDir}/wordpress.zip`)
        .pipe(decompress())
        .pipe(gulp.dest(config.tempDir))
        .on('end', () => {
          // Mover archivos desde wordpress/ al buildDir
          gulp.src(`${config.tempDir}/wordpress/**/*`)
            .pipe(gulp.dest(config.buildDir))
            .on('end', done);
        });
    });
  }).on('error', (err) => {
    fs.unlink(filePath, () => {}); // Limpiar archivo parcial
    log.error(colors.red(`Error descargando WordPress: ${err.message}`));
    done(err);
  });
});

// Build de actualización (solo wp-content)
gulp.task('build-update', 
  gulp.series('clean', () => {
    return gulp.src([...config.updateIncludes, ...config.excludes])
      .pipe(gulp.dest(config.buildDir))
      .pipe(zip(config.zipName('update')))
      .pipe(gulp.dest('./builds'));
  })
);

// Build completo (instalación inicial)
gulp.task('build-full', 
  gulp.series('clean', 'init', 'download-wp', () => {
    return gulp.src([...config.fullIncludes, ...config.excludes], { base: '.' })
      .pipe(gulp.dest(config.buildDir))
      .pipe(zip(config.zipName('full')))
      .pipe(gulp.dest(config.buildsDir));
  })
);

// Tarea por defecto
gulp.task('default', (done) => {
  log(colors.blue('Tareas disponibles:'));
  log(colors.yellow('gulp build-update') + ' - Genera build de actualización');
  log(colors.yellow('gulp build-full') + ' - Genera build completo con WordPress');
  log(colors.yellow('gulp clean') + ' - Limpia directorios temporales');
  done();
}); 