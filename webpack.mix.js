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

mix
   .js('resources/js/app.js', 'public/js')
	.js('resources/js/src/index-location.js', 'public/js')
	.js('resources/js/src/libs.js', 'public/js')
	.copyDirectory('resources/images', 'public/assets/images')
	.copyDirectory('resources/css', 'public/css')
	.styles([
            'resources/css/style.css',
            'resources/css/custom.css',
            'resources/css/responsive.css',
	    ],
        'public/css/main.css')
   .sass('resources/sass/app.scss', 'public/css')
   .setPublicPath('public');
