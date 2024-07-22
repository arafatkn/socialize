<?php

namespace App\Mixins;

use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\Facades\DB;

class AutoIncrementColumnMixin
{
    /**
     * @return \Closure
     */
    public function bigAutoIncrement(): \Closure
    {
        return function ($column = 'id'): ColumnDefinition {
            $sequence_name = "{$this->table}_{$column}_seq";
            DB::statement("CREATE SEQUENCE IF NOT EXISTS $sequence_name START 1 INCREMENT 1;");
            return $this->unsignedBigInteger($column)->default(DB::raw("nextval('$sequence_name'::regclass)"));
            //            return $this->addColumn('biginteger', $column, ['unsigned' => true, 'autoIncrement' => true]);
        };
    }

    /**
     * @return \Closure
     */
    public function autoIncrement(): \Closure
    {
        return function ($column = 'id'): ColumnDefinition {
            $sequence_name = "{$this->table}_{$column}_seq";
            DB::statement("CREATE SEQUENCE IF NOT EXISTS $sequence_name START 1 INCREMENT 1;");
            return $this->unsignedInteger($column)->default(DB::raw("nextval('$sequence_name'::regclass)"));
        };
    }

    /**
     * @return \Closure
     */
    public function smallAutoIncrement(): \Closure
    {
        return function ($column = 'id'): ColumnDefinition {
            $sequence_name = "{$this->table}_{$column}_seq";
            DB::statement("CREATE SEQUENCE IF NOT EXISTS $sequence_name START 1 INCREMENT 1;");
            return $this->unsignedSmallInteger($column)->default(DB::raw("nextval('$sequence_name'::regclass)"));
        };
    }
}
