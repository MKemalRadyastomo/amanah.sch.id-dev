<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('presence.entry_hour', '07:15');
        $this->migrator->add('presence.exit_hour', '15:00');
    }
};
