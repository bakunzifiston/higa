<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role && $this->role->slug === 'admin';
    }

    public function isCollectionOfficer()
    {
        return $this->role && $this->role->slug === 'collection-officer';
    }

    public function isProductionManager()
    {
        return $this->role && $this->role->slug === 'production-manager';
    }

public function isSalesTeam()
    {
        return $this->role && $this->role->slug === 'sales-team';
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        if (!$this->role) {
            return false;
        }
        // Admin has all roles
        if ($this->role->slug === 'admin') {
            return true;
        }
        return $this->role->slug === $role;
    }

/**
     * Check if user can perform an action based on role.
     * Renamed to avoid conflict with Laravel's Auth User::can()
     */
    public function canAccess(string $ability): bool
    {
        return match ($ability) {
            'admin' => $this->isAdmin(),
            'manage users', 'manage roles' => $this->isAdmin(),
            'manage data', 'edit any', 'delete any' => $this->isAdmin() || $this->hasRole('manager'),
            'view reports' => $this->isAdmin() || $this->hasRole('manager') || $this->hasRole('clerk'),
            default => $this->isAdmin(),
        };
    }

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
        ];
    }
}
