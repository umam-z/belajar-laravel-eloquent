<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'title'=>'Sample Title',
        'comment'=>'Sample Comments',
    ];
}
