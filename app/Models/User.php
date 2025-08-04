<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\States\UserStatus\UserStatus;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\ModelStates\HasStates;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasMedia
{
    use HasFactory, HasRoles, HasStates, InteractsWithMedia, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'personal_number',
        'phone',
        'address',
        'place_of_birth',
        'date_of_birth',
        'status',
        'registered_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date:Y-m-d',
        'status' => UserStatus::class,
        'registered_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            $user->password ??= $user->date_of_birth?->format('dmy');
            $user->registered_at ??= now();
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function currentPresence(): Model|Presence
    {
        return $this->presences()
            ->whereDate('created_at', now()->toDateString())
            ->firstOrCreate();
    }

    public function presences(): HasMany
    {
        return $this->hasMany(Presence::class);
    }
}
