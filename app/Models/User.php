<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Allow all fields to be fillable
    protected $guarded = []; 

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            // 'header_images' and 'page_sections' removed. 
            // They are now in the Business model.
        ];
    }

    /**
     * RELATIONSHIP: A User owns multiple Businesses.
     * This is the core of your new Multi-Tenant system.
     */
    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    /**
     * FILAMENT ACCESS CONTROL
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Only allow Super Admins to access the Filament Admin Panel
        return $this->profile_type === 'super_admin';
    }
}