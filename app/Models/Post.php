<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $table = 'posts';

    public $fillable = ['slug','title','event_date','description','images','gallery_type'];

    public $primaryKey = 'id';
}
