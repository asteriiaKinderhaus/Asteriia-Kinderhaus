<?php

namespace App\Traits;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait HasPermission
{
    public function hasPermission(string $permission): bool
    {
        // support environments where Eloquent's loadMissing may not be available
        if (method_exists($this, 'loadMissing')) {
            $this->loadMissing('role.permissions');
        } elseif (method_exists($this, 'load')) {
            $this->load('role.permissions');
        }

        return $this->role
            ->permissions
            ->contains('code', $permission);
    }
}
