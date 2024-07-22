<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use BelongsToTenant;

    protected $guarded = ['id', 'site_id', 'created_at', 'updated_at'];

    protected $hidden = ['site_id'];
}
