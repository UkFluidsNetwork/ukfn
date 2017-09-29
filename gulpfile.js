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
    mix.copy('node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
             'public/js/bootstrap.min.js');
    mix.copy('node_modules/jquery/dist/jquery.min.js',
             'public/js/jquery.min.js');
    mix.copy('node_modules/angular/angular.min.js',
             'public/js/angular.min.js');
    mix.copy('node_modules/angular-messages/angular-messages.min.js',
             'public/js/angular-messages.min.js');
    mix.copy('node_modules/ngstorage/ngStorage.min.js',
             'public/js/ngStorage.min.js');
    mix.copy('node_modules/ngmap/build/scripts/ng-map.min.js',
             'public/js/ng-map.min.js');
    mix.copy('node_modules/angular-selectize2/dist/selectize.js',
             'public/js/selectize.js');
    mix.copy('node_modules/angularjs-dropdown-multiselect/dist/angularjs-dropdown-multiselect.min.js',
             'public/js/angularjs-dropdown-multiselect.min.js');
    mix.sass('main.scss');
});
