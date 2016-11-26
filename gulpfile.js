var elixir = require('laravel-elixir');

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

elixir(function(mix) {
    mix.sass('main.scss');       
    // TO BE ENABLED ONCE GULP ELIXIR IS FIXED
    // mix.copy('./node_modules/ngmap/build/scripts/ng-map.min.js', './public/js/vendor/ng-map.min.js');
    // mix.copy('./node_modules/angular/angular.js', './public/js/vendor/angular.js');
    // mix.copy('./node_modules/angular-messages/angular-messages.js', './public/js/vendor/angular-messages.js');
});