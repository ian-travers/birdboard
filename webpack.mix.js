let mix = require('laravel-mix');

require('laravel-mix-tailwind');

mix
    .setPublicPath('public/build')
    .setResourceRoot('/build/')
    .js('resources/js/app.js', 'js')
    .sass('resources/sass/app.scss', 'css')
    .tailwind('./tailwind.config.js')
    .version();
