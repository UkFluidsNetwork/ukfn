angular
    .module('ukfn', [
        'ngStorage',
        'ngMessages',
        'ngMap',
        'angularjs-dropdown-multiselect',
        'selectize'])
    .config(function($sceDelegateProvider) {
        $sceDelegateProvider.resourceUrlWhitelist([
          // Allow same origin resource loads.
          'self',
          // Allow loading from our assets domain.
          // Notice the difference between * and **.
          'https://upload.sms.cam.ac.uk/**',
          'https://sms.cam.ac.uk/**',
          'http://sms.cam.ac.uk/**']);
 });