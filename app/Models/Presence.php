<?php

namespace App\Models;

use App\Settings\PresenceSetting;
use App\States\PresenceStatus\PresenceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStates\HasStates;

class Presence extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasStates;

    protected $fillable = [
        'user_id',
        'start_at',
        'end_at',
        'start_token',
        'end_token',
        'status',
        'reason',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'status' => PresenceStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isOverdue(): ?bool
    {
        $entryHour = app(PresenceSetting::class)->entry_hour;

        return $this->start_at?->lessThanOrEqualTo(now()->setTimeFromTimeString($entryHour));
    }

    public function isUntimely(): ?bool
    {
        $exitHour = app(PresenceSetting::class)->exit_hour;

        return $this->end_at?->greaterThanOrEqualTo(now()->setTimeFromTimeString($exitHour));
    }
}
