<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkMovie extends Model
{
    public $timestamps = false;
    use HasFactory;
    use HasFactory;
    protected $table = 'linkmovie';
    protected $fillable = [
        'title','description','status'
    ];
}
