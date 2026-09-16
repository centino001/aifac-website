<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_super_admin',
        'permissions',
    ];

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
            'is_admin' => 'boolean',
            'is_super_admin' => 'boolean',
            'permissions' => 'array',
        ];
    }

    /**
     * Can access the admin panel at all.
     */
    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    public function isSuperAdmin(): bool
    {
        return $this->isAdmin() && (bool) $this->is_super_admin;
    }

    /**
     * @return list<string>
     */
    public function permissionKeys(): array
    {
        return array_keys(config('admin_permissions', []));
    }

    /**
     * @return list<string>
     */
    public function getPermissionsList(): array
    {
        if ($this->isSuperAdmin()) {
            return $this->permissionKeys();
        }

        return array_values(array_intersect(
            $this->permissionKeys(),
            $this->permissions ?? []
        ));
    }

    public function hasPermission(string $permission): bool
    {
        if (! $this->isAdmin()) {
            return false;
        }

        // Profile is always available to admin users.
        if ($permission === 'profile') {
            return true;
        }

        if ($this->isSuperAdmin()) {
            return true;
        }

        return in_array($permission, $this->permissions ?? [], true);
    }

    public function defaultAdminPath(): string
    {
        $permissions = config('admin_permissions', []);

        foreach ($permissions as $key => $meta) {
            if ($this->hasPermission($key)) {
                return $meta['path'];
            }
        }

        return '/admin/profile';
    }

    public function roleLabel(): string
    {
        if ($this->isSuperAdmin()) {
            return 'Super Admin';
        }

        return 'Staff';
    }
}
