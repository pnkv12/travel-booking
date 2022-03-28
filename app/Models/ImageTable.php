<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageTable extends Model
{
    use HasFactory;

    protected $table = 'images';
    protected $primaryKey = 'photo_id';
    protected $fillable = ['photo_id', 'photo_name', 'size', 'created_at', 'updated_at'];

    public function getList()
    {
        $data = $this->select(
            'photo_id',
            'photo_name',
            'size',
            'created_at',
            'updated_at'
        );
        return $data->paginate(5);
    }

    public function deletePhoto($id)
    {
        return $this->where('photo_id', $id)
            ->delete();
    }

    public function getPhotoID()
    {
        return $this->select('photo_id', 'photo_name')
            ->get();
    }
}
