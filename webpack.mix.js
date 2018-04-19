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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
    // 后面自己添加的 添加编辑器simditor http://simditor.tower.im/
   .copyDirectory('resources/assets/editor/js','public/editor/js')
   .copyDirectory('resources/assets/editor/css','public/editor/css');
