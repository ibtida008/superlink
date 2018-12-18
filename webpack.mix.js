let mix = require('laravel-mix');

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


mix.js('resources/assets/js/app_user.js', 'public/js')
   .sass('resources/assets/sass/app_user.scss', 'public/css');

mix.js('resources/assets/js/app_admin.js', 'public/js')
   .sass('resources/assets/sass/app_admin.scss', 'public/css');

mix.js('resources/assets/js/app_search.js', 'public/js')
   .sass('resources/assets/sass/app_search.scss', 'public/css');