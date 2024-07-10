<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('backup:app')->dailyAt('03:00');
