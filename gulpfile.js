// Include gulp
var gulp = require('gulp');

// Include Our Plugins
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var imagemin = require('gulp-imagemin');


// Compile Our Sass
gulp.task('sass', function() {
        return gulp.src([
            'assets/css/*' 
        ]) 
        .pipe(sass())
        .pipe(concat('main.scss'))
        .pipe(rename('all.min.css'))
        .pipe(gulp.dest('dist/css'));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
    return gulp.src([
            'assets/js/jquery.min.js',
            'assets/js/tether.min.js',
            'assets/js/bootstrap.min.js',
            'assets/js/datatables.min.js',
            'assets/js/datatables-pdf.min.js',
            'assets/js/datatables-buttons.min.js',
            'assets/js/datatables-select.min.js',
            'assets/js/select.min.js',
            'assets/js/parsley.min.js',
            'assets/js/main.js' 
        ])
        .pipe(concat('main.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('dist/js/'));
}); 

// Minify Images
gulp.task('imagemin', function() {
    return gulp.src('assets/images/*')
        .pipe(imagemin())
        .pipe(gulp.dest('dist/images/'))
});



// Watch Files For Changes
gulp.task('watch', function() {
    gulp.watch('assets/js/*.js', ['scripts']);
    gulp.watch('assets/css/*.scss', ['sass']);
});

// Default Task
gulp.task('default', ['sass', 'scripts', 'imagemin', 'watch']);