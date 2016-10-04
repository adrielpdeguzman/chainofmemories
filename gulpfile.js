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
        .copy('./node_modules/normalize.css/normalize.css', './public/css/vendor')
        .browserSync({
            notify: false,
            open: false,
            proxy: 'chainofmemories.app',
        });
});
