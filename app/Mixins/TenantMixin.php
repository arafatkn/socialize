<?php

namespace App\Mixins;

use Closure;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Database\Schema\IndexDefinition;
use Illuminate\Support\Fluent;

/**
 * @mixin Blueprint
 */
class TenantMixin
{
    /**
     * @return Closure
     */
    public function tenantId(): Closure
    {
        return function (): ColumnDefinition {
            return $this->unsignedBigInteger('site_id');
        };
    }

    /**
     * Creates a primary key with tenant id
     *
     * @return Closure
     */
    public function tenantPrimary(): Closure
    {
        return function (array $columns, $name = null, $algorithm = null) : IndexDefinition|Fluent {
            array_unshift($columns, 'site_id');

            return $this->primary(...func_get_args());
        };
    }

    /**
     * Creates a unique index with tenant id
     *
     * @return Closure
     */
    public function tenantUnique(): Closure
    {
        return function (array $columns, $name = null, $algorithm = null) : IndexDefinition|Fluent {
            array_unshift($columns, 'site_id');

            return $this->unique(...func_get_args());
        };
    }

    /**
     * Creates an index with tenant id
     *
     * @return Closure
     */
    public function tenantIndex(): Closure
    {
        return function (array $columns, $name = null, $algorithm = null) : IndexDefinition|Fluent {
            array_unshift($columns, 'site_id');

            return $this->index(...func_get_args());
        };
    }
}
