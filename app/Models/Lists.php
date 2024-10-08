<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    use HasFactory;

    protected $table = 'lists';
    protected $primaryKey = 'list_id';
    protected $fillable = [
        'list_name',
        'list_desc',
        'list_status'
    ];
}
