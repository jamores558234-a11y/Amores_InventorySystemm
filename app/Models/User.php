<?php
// FILE PATH: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'role', 'password'];
    protected $hidden   = ['password', 'remember_token'];
    protected $casts    = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    // ── Role checks ───────────────────────────────────────────
    public function isAdmin(): bool            { return $this->role === 'admin'; }
    public function isInventoryManager(): bool { return $this->role === 'manager'; }
    public function isManager(): bool          { return $this->role === 'manager'; } // alias
    public function isStaff(): bool            { return $this->role === 'staff'; }

    // ── Permission checks based on flowchart ──────────────────

    // Admin only
    public function canManageUsers(): bool     { return $this->isAdmin(); }
    public function canConfigureSystem(): bool { return $this->isAdmin(); }

    // Inventory Manager only
    public function canAddProduct(): bool      { return $this->isInventoryManager(); }
    public function canUpdateProduct(): bool   { return $this->isInventoryManager(); }
    public function canDeleteProduct(): bool   { return $this->isInventoryManager(); }
    public function canViewInventory(): bool   { return $this->isInventoryManager() || $this->isAdmin(); }
    public function canRequestItem(): bool     { return $this->isInventoryManager(); }
    public function canBorrowItem(): bool      { return $this->isInventoryManager(); }
    public function canReturnItem(): bool      { return $this->isInventoryManager(); }

    // Shared
    public function canMonitorStock(): bool    { return true; } // all roles
    public function canViewProducts(): bool    { return true; } // all roles

    // Shorthand used in controllers and views
    public function canEdit(): bool            { return $this->isInventoryManager(); }
    public function canDelete(): bool          { return $this->isInventoryManager(); }

    // ── UI Helpers ────────────────────────────────────────────
    public function getRoleBadgeColor(): string
    {
        return match($this->role) {
            'admin'   => '#c9a84c',
            'manager' => '#6366f1',
            'staff'   => '#14b8a6',
            default   => '#6b7694',
        };
    }

    public function getRoleIcon(): string
    {
        return match($this->role) {
            'admin'   => 'fa-shield-halved',
            'manager' => 'fa-boxes-stacked',
            'staff'   => 'fa-user',
            default   => 'fa-user',
        };
    }

    public function getRoleLabel(): string
    {
        return match($this->role) {
            'admin'   => 'Administrator',
            'manager' => 'Inventory Manager',
            'staff'   => 'Staff',
            default   => 'User',
        };
    }

    // ── Relationships ─────────────────────────────────────────
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}