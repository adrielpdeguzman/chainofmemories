const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');
require('laravel-elixir-stylus');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
     mix.stylus('app.styl')
        .webpack('app.js')
        .styles([
            './node_modules/font-awesome/css/font-awesome.css',
            './node_modules/normalize.css/normalize.css',
        ], './public/css/vendors.css')
        .copy('node_modules/font-awesome/fonts', 'public/fonts')
        .browserSync({
            notify: false,
            open: false,
            proxy: 'chainofmemories.app',
        });
});
