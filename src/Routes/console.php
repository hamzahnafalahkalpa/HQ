<?php 

use Illuminate\Support\Facades\Schedule;
use Projects\Hq\Commands\GenerateBillingCommand;

Schedule::command(GenerateBillingCommand::class, [])->daily()->runInBackground();