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
## Cronjobs
The app's mailing system and talk update depends on two cronjobs. One.com does not allow setting up cronjobs so the workaround is to set them in a different machine that activates a couple of bash scripts in the actual server.

`run-listener` runs the `artisan queue:listen` command, which listens for new mailing jobs to execute:
```
*/10 * * * *  ssh ukfluids.net@ssh.ukfluids.net "bash ~/run-listener"
```
`run-scheduler` runs the `artisan schedule:run` command, which is in charge of [laravel's task scheduler](https://laravel.com/docs/5.4/scheduling), allowing cronjob like behaviour with php. All the commands that the scheduler will run are specified in `app/Console/Kernel.php`, under the `schedule()` function.
```
* * * * *  ssh ukfluids.net@ssh.ukfluids.net "bash ~/run-scheduler"
```

## Built with
* [Laravel 5](http://laravel.com/docs) - The PHP framework used
* [Angular.js](https://angularjs.org/) - The JavaScript framework used for retrieving and displaying data
* [jQuery 2](https://api.jquery.com/) - The JavaScript framework used for minor modifications in the GUI
* [Gulp](https://github.com/gulpjs/gulp/blob/master/docs/API.md) - SASS compiler
* [Bootstrap 3](http://getbootstrap.com/components/) - Front end framework
* [npm](https://docs.npmjs.com/) - Dependency Management

