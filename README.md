# UK Fluids Network website

## Installation
The project depends on a series of node packages
```sh
npm install
```

The main CSS code is compiled from SASS using gulp
```sh
gulp
```

## Mailqueue
Laravel provides [job queues](https://laravel.com/docs/5.2/queues), which we use to handle sending email.

To monitor the queue worker we use supervisor, a process monitor for linux. Supervisor will run different processes and automatically restart them if they stop for any readon. The command to run the queue worker is:

```sh
artisan queue:work --sleep=3 --tries=5 --daemon
```

Since daemon queue workers are long-lived processes, they will not pick up changes in your code without being restarted. To do so:

```sh
php artisan queue:restart
```

## Cronjobs

`artisan schedule:run` command, which is in charge of [laravel's task scheduler](https://laravel.com/docs/5.4/scheduling), allows cronjob like behaviour with php. All the commands that the scheduler will run are specified in `app/Console/Kernel.php`, under the `schedule()` function. A single cronjob entry is required:
```
* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

## Built with
* [Laravel 5](http://laravel.com/docs) - The PHP framework used
* [Angular.js](https://angularjs.org/) - The JavaScript framework used for retrieving and displaying data
* [jQuery 2](https://api.jquery.com/) - The JavaScript framework used for minor modifications in the GUI
* [Gulp](https://github.com/gulpjs/gulp/blob/master/docs/API.md) - SASS compiler
* [Bootstrap 3](http://getbootstrap.com/components/) - Front end framework
* [npm](https://docs.npmjs.com/) - Dependency Management

