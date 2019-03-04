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
    .js('app/Classes/UberGallery/colorbox/jquery.colorbox.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .styles([
        'app/Classes/UberGallery/UberGallery.css',
        'app/Classes/UberGallery/colorbox/1/colorbox.css'
    ], 'public/css/app.css');
