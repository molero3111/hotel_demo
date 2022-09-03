const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .styles([
      'public/lib/bootstrap/css/bootstrap.min.css',
      'public/lib/datepicker/jquery.datetimepicker.min.css',
      'public/lib/w3.css',
      'public/styles/fonts.css',
      'public/styles/main_styles.css'
   ], 'public/css/styles.css')
   .scripts([
      'public/lib/bootstrap/js/jquery.min.js',
      'public/lib/bootstrap/js/@popperjs/core/dist/umd/popper.min.js',
      'public/lib/sweetalert.min.js',
      'public/lib/bootstrap/js/bootstrap.js',
      'public/lib/datepicker/jquery.datetimepicker.full.min.js',
      'public/js/hotel_functions.js' ,     
   ], 'public/js/scripts.js');
