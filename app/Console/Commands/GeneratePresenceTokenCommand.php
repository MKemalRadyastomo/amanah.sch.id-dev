<?php

namespace App\Console\Commands;

use App\Settings\PresenceSetting;
use Illuminate\Console\Command;
use Str;

class GeneratePresenceTokenCommand extends Command
{
    protected $signature = 'presence:generate-token';

    protected $description = 'Command description';

    public function handle(): void
    {
        $setting = app(PresenceSetting::class);
        $setting->token = Str::random().uniqid();
        $setting->save();
    }
}
