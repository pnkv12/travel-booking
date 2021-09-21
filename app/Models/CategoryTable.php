<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTable extends Model
{
    use HasFactory;
    protected $table = 'category';         //Tên table
    protected $primaryKey = 'id'; //Tên khóa chính
    protected $fillables = [
        'id',
        'cate_name'
    ];

    public function getCate()
    {
        return $this->select('id', 'cate_name')
            ->get();
    }
}
