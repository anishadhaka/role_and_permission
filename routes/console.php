<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Artisan::command('ask:name', function () {
    $name = $this->ask('What is your name?');
    $this->info('Hello, ' . $name);
});
Artisan::command('confirm:action', function () {
    if ($this->confirm('Do you really want to proceed?')) {
        $this->info('Proceeding...');
    } else {
        $this->warn('Action cancelled.');
    }
});
Artisan::command('run:migrate', function () {
    $this->call('migrate');
});
Artisan::command('run:serve', function () {
    $this->call('serve'); //php artisan run:serve

});