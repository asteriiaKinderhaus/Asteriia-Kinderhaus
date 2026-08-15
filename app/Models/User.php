<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Facilitator;
use App\Models\Admin;
use App\Models\ParentModel;
use App\Traits\HasPermission;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasPermission;

    protected $table = 'users';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'username',
        'password',
        'role_id',
        'status',
        'reset_password_token',
        'reset_password_expires_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'password_reset_expires_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke tabel roles
     */
    public function role()
    {
        return $this->belongsTo(
            Role::class,
            'role_id',
            'id'
        );
    }

    /**
     * Relasi ke tabel admins
     */
    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }

    /**
     * Relasi ke tabel facilitators
     */
    public function facilitator()
    {
        return $this->hasOne(Facilitator::class, 'user_id', 'id');
    }

    /**
     * Relasi ke tabel parents
     */
    public function parentData()
    {
        return $this->hasOne(ParentModel::class);
    }

    public function isAdmin(): bool
    {
        return $this->role_id === 'ADM';
    }

    public function isFacilitator(): bool
    {
        return $this->role_id === 'FAS';
    }

    public function isParent(): bool
    {
        return $this->role_id === 'PAR';
    }

    /**
     * AdminLTE User Image
     */
    public function adminlte_image()
    {
        return asset('images/users/default.png');
    }

    /**
     * AdminLTE User Description
     */
    public function adminlte_desc()
    {
        return $this->role?->nama;
    }

    public function adminlte_name()
    {
        return match ($this->role_id) {
            'ADM' => optional($this->admin)->name,
            'FAS' => optional($this->facilitator)->name,
            'PAR' => optional($this->parentData)->name,
            default => $this->username,
        };
    }

    /**
     * AdminLTE Profile URL
     */
    public function adminlte_profile_url()
    {
        return route('admin.dashboard');
    }

    public function getNameAttribute()
    {
        if ($this->admin) {
            return $this->admin->name;
        }

        if ($this->facilitator) {
            return $this->facilitator->name;
        }

        if ($this->parentData) {
            return $this->parentData->name;
        }

        return '-';
    }

    public function getEmailAttribute()
    {
        if ($this->admin) {
            return $this->admin->email;
        }

        if ($this->facilitator) {
            return $this->facilitator->email;
        }

        if ($this->parentData) {
            return $this->parentData->email;
        }

        return null;
    }
}
