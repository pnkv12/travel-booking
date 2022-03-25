<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageTable extends Model
{
    use HasFactory;

    protected $table = 'images';
    protected $primaryKey = 'photo_id';
    protected $fillable = ['photo_id', 'photo_name', 'created_at', 'updated_at'];


    // public function uploadPhoto($img)
    // {
    //     return $this->insert($img);
    // }
}
