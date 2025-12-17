<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // --- THIS IS THE IMPORTANT PART ---
    // We use guarded = [] to allow ALL fields (store_name, profile_type, etc.) to be saved.
    // We DELETED the $fillable array because it was blocking the other fields.
    protected $guarded = []; 

    protected static function booted()
    {
        static::saving(function ($user) {
            if ($user->store_name && !$user->store_slug) {
                // 1. Auto-generate Slug (e.g. "ABC Hardware" -> "abc-hardware")
                $user->store_slug = \Illuminate\Support\Str::slug($user->store_name);
                
                // 2. Generate QR Code URL
                $url = url('/v/' . $user->store_slug);
                
                // 3. Create the QR Image
                $qrContent = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(300)->generate($url);
                
                // 4. Save it to storage
                $filename = 'qrcodes/' . $user->store_slug . '.svg';
                \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $qrContent);
                
                $user->qr_code_path = $filename;
                
                // Ensure they are marked as a vendor/service provider
                $user->is_vendor = true;
            }
        });
    }

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
            'header_images' => 'array',
        ];
    }

    // Relationships for the Dashboard
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // ONLY allow if profile_type is 'super_admin'
        // You can add more roles here later like: in_array($this->profile_type, ['super_admin', 'manager'])
        return $this->profile_type === 'super_admin';
    }
}