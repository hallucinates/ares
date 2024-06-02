<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->daily()->at('01:30');

Schedule::command('app:ambil-master-layanan')->everyMinute();
Schedule::command('app:cek-status-layanan')->everyMinute();

Schedule::command('app:order-pesanan')->everyMinute();
Schedule::command('app:cek-status-pesanan')->everyMinute();
Schedule::command('app:batal-pesanan')->everyMinute();
