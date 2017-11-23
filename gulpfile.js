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

// NB. Use gulp --production to obtain minimize versions

var elixir = require('laravel-elixir');

elixir(function(mix) {
    // copy js from vendor packages to public/js
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
    mix.copy('node_modules/angularjs-dropdown-multiselect/dist/angularjs-dropdown-multiselect.min.js', 'public/js/angularjs-dropdown-multiselect.min.js');
    mix.copy('resources/assets/js/vendor',
             'public/js/vendor');
    mix.copy('vendor/ckeditor/ckeditor',
             'public/ckeditor');

    // move scripts to public/js
    mix.scripts(['main.js', '../../../node_modules/jquery/dist/jquery.min.js',
   '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js'],
                'public/js/main.js')
       .scripts(['analytics.js'], 'public/js/analytics.js')
       .scripts(['angApp.js'], 'public/js/angApp.js')
       .scripts(['directoryCtrl.js'], 'public/js/directoryCtrl.js')
       .scripts(['resourcesCtrl.js'], 'public/js/resourcesCtrl.js')
       .scripts(['sigCtrl.js'], 'public/js/sigCtrl.js')
       .scripts(['talksCtrl.js'], 'public/js/talksCtrl.js')

    // copy css from vendor packages to sass folder
    mix.copy('node_modules/selectize-scss/src',
             'resources/assets/sass/selectize');
    mix.copy('vendor/components/font-awesome/scss',
             'resources/assets/sass/font-awesome');
    mix.copy('node_modules/bootstrap-sass/assets/stylesheets/_bootstrap.scss',
             'resources/assets/sass/_bootstrap.scss');
    mix.copy('node_modules/bootstrap-sass/assets/stylesheets/bootstrap',
             'resources/assets/sass/bootstrap');
    mix.copy('resources/assets/sass/vendor',
             'public/css/vendor');

    // copy fonts to public/build/fonts
    mix.copy('vendor/components/font-awesome/fonts',
             'public/build/fonts');
    mix.copy('resources/assets/fonts/lato-fonts',
             'public/build/fonts/lato-fonts');
    mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap',
             'public/build/fonts/bootstrap');


    // compile all sass to css and move to public/css
    mix.sass('main.scss');

    // include version
    // See: https://laravel.com/docs/5.3/elixir#versioning-and-cache-busting
    mix.version(['public/css/main.css', 'public/js/main.js']);
});
