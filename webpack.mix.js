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
mix.js('resources/js/app.js', 'public/js/')
    .sass('resources/sass/app.scss', 'public/css/');
/*

mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/','public/fonts/bootstrap');
*/
mix.copy('app/Widgets/Resources/js/gridx.js', 'public/js/gridx.js')
    .copy('app/Widgets/Resources/css/gridx.css', 'public/css/gridx.css')
    .version();
//mix.browserSync('lengine.dev');

