// Aqui nós carregamos o gulp e os plugins através da função `require` do nodejs
var gulp = require('gulp');
var jshint = require('gulp-jshint');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var cssmin = require("gulp-cssmin");
// Remove comentários CSS
var stripCssComments = require('gulp-strip-css-comments');

// Definimos o diretorio dos arquivos para evitar repetição futuramente
var files = [
    "./web/assets/blog-new/js/*.js",
    "./web/assets/blog-new/js/vendor/*.js",
];

/*
 "./web/assets/plugins/alertifyjs/*.js",
 "./web/assets/plugins/jQuery-Chord-Transposer/*.js",
 "./web/assets/plugins/jQuery.filer/js/*.js",
 "./web/assets/vendor/jquery/dist/jquery.js",
 "./web/assets/vendor/jasny-bootstrap/dist/js/*.min.js",
 "./web/assets/vendor/react/*.js",
 "./web/assets/plugins/snackbarjs/dist/*.min.js",
 "./web/assets/vendor/emojionearea/dist/*.min.js"
*
* */

//Aqui criamos uma nova tarefa através do ´gulp.task´ e damos a ela o nome 'lint'
gulp.task('lint', function() {

// Aqui carregamos os arquivos que a gente quer rodar as tarefas com o `gulp.src`
// E logo depois usamos o `pipe` para rodar a tarefa `jshint`
    gulp.src(files)
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

//Criamos outra tarefa com o nome 'dist'
gulp.task('dist', function() {

// Carregamos os arquivos novamente
// E rodamos uma tarefa para concatenação
// Renomeamos o arquivo que sera minificado e logo depois o minificamos com o `uglify`
// E pra terminar usamos o `gulp.dest` para colocar os arquivos concatenados e minificados na pasta build/
    gulp.src(files)
        .pipe(concat('./web/assets/dist'))
        .pipe(rename('dist.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./web/assets/dist'));
});

//Criamos uma tarefa 'default' que vai rodar quando rodamos `gulp` no projeto
gulp.task('default', function() {

// Usamos o `gulp.run` para rodar as tarefas
// E usamos o `gulp.watch` para o Gulp esperar mudanças nos arquivos para rodar novamente
    gulp.run('lint', 'dist');
    gulp.watch(files, function(evt) {
        gulp.run('lint', 'dist');
    });
});

var css = [
    './web/assets/plugins/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.css',
    './web/assets/vendor/jasny-bootstrap/dist/css/jasny-bootstrap.css',
    './web/assets/blog-new/css/*.css',
    './web/assets/plugins/jQuery-Chord-Transposer/jquery.transposer.css',
    './web/assets/plugins/jQuery.filer/css/jquery.filer.css',
];

// Processo que agrupará todos os arquivos CSS, removerá comentários CSS e minificará.

// Cria a TASK padrão, esta linha será processada quando o comando "GULP" for executado
gulp.task('default-css', function () {
    gulp.src(css)
        .pipe(concat('style.min.css'))
        .pipe(stripCssComments({all: true}))
        .pipe(cssmin())
        .pipe(gulp.dest('./web/assets/dist/css/'));
});

// Cria a TASK de verificar em tempo real alterações, se detectar alguma alteração, será processado o comando relativo ao arquivo
gulp.task('watch', function() {
    gulp.watch(css, ['minify-css']);
});