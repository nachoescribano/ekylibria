const gulp = require('gulp');
const zip = require('gulp-zip');
const clean = require('gulp-clean');
const replace = require('gulp-replace');
const dateFormat = require('dateformat');

// Configuración
const config = {
  buildDir: './build',
  zipName: () => `site-build-${dateFormat(new Date(), "yyyy-mm-dd-HHMMss")}.zip`,
  // Archivos a incluir
  includes: [
    '**/*',
    'wp-content/**/*',
    'wp-content/themes/**/*',
    'wp-content/plugins/**/*',
  ],
  // Archivos a excluir
  excludes: [
    '!node_modules/**',
    '!build/**',
    '!gulpfile.js',
    '!package.json',
    '!package-lock.json',
    '!.git/**',
    '!wp-config.php',
    '!.env',
    '!README.md'
  ]
};

// Limpiar directorio build
gulp.task('clean', () => {
  return gulp.src(config.buildDir, { allowEmpty: true })
    .pipe(clean({ force: true }));
});

// Copiar archivos al build
gulp.task('copy', () => {
  return gulp.src([...config.includes, ...config.excludes])
    .pipe(gulp.dest(config.buildDir));
});

// Crear ZIP
gulp.task('zip', () => {
  return gulp.src(`${config.buildDir}/**/*`)
    .pipe(zip(config.zipName()))
    .pipe(gulp.dest('./'));
});

// Tarea principal
gulp.task('build', 
  gulp.series('clean', 'copy', 'zip')
); 