<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'comment',
        'parent_id',
    ];

    public function getCreatedAtAttribute($value)
    {
        $date = new DateTime($value);
        return $date->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        $date = new DateTime($value);
        return $date->format('Y-m-d H:i');
    }
}
