<?php

namespace App\Traits;

use App\Models\Scopes\TenantScope;

trait BelongsToTenant
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TenantScope);

        if (!app()->runningInConsole()) {
            static::creating(function ($model) {
                $model->site_id = request()->attributes->get('tenant_id');
            });
        }
    }
}
