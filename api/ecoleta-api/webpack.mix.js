const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
.copy('resources/css', 'public/css')
.copy('resources/js', 'public/js')
.copy('resources/vendor', 'public/vendor')
.copy('resources/img', 'public/img');
