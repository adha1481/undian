<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable - Field yang bisa diisi
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization - Field yang disembunyikan
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast - Casting tipe data
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    /**
     * Konstanta untuk role admin
     */
    const ROLE_SUPER_ADMIN = 'super_admin';
    const ROLE_ADMIN_UNDIAN = 'admin_undian';
    const ROLE_ADMIN_PESERTA = 'admin_peserta';
    const ROLE_ADMIN_HADIAH = 'admin_hadiah';

    /**
     * Cek apakah user adalah super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    /**
     * Cek apakah user adalah admin undian
     */
    public function isAdminUndian(): bool
    {
        return $this->role === self::ROLE_ADMIN_UNDIAN || $this->isSuperAdmin();
    }

    /**
     * Cek apakah user adalah admin peserta
     */
    public function isAdminPeserta(): bool
    {
        return $this->role === self::ROLE_ADMIN_PESERTA || $this->isSuperAdmin();
    }

    /**
     * Cek apakah user adalah admin hadiah
     */
    public function isAdminHadiah(): bool
    {
        return $this->role === self::ROLE_ADMIN_HADIAH || $this->isSuperAdmin();
    }

    /**
     * Cek apakah user memiliki akses ke fitur tertentu
     */
    public function hasAccess(string $feature): bool
    {
        if (!$this->is_active) {
            return false;
        }

        switch ($feature) {
            case 'undian':
                return $this->isAdminUndian();
            case 'peserta':
                return $this->isAdminPeserta();
            case 'hadiah':
                return $this->isAdminHadiah();
            case 'super_admin':
                return $this->isSuperAdmin();
            default:
                return false;
        }
    }

    /**
     * Get role label untuk tampilan
     */
    public function getRoleLabel(): string
    {
        return match ($this->role) {
            self::ROLE_SUPER_ADMIN => 'Super Admin',
            self::ROLE_ADMIN_UNDIAN => 'Admin Undian',
            self::ROLE_ADMIN_PESERTA => 'Admin Peserta',
            self::ROLE_ADMIN_HADIAH => 'Admin Hadiah',
            default => 'Unknown'
        };
    }
}
