<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTable extends Model
{
    use HasFactory;
    protected $table = 'news';    //Tên table
    protected $primaryKey = 'id'; //Tên khóa chính
    protected $fillables = ['id', 'title', 'content','category_id','author','photo','created_at','updated_at','is_shown'];

    public function getList()
    {
        $data = $this->select(
            'news.id',
            'news.title',
            'news.content',
            'news.category_id',
            'news.author',
            'news.photo',
            'news.created_at',
            'news.is_shown',
            'c.cate_name',
            'u.fullname',
        )
            ->leftjoin('category as c', 'news.category_id', '=', 'c.id')
            ->leftjoin('users as u', 'news.author', '=', 'u.id');
        return $data->paginate(5);
    }

    public function addNew($data)
    {
        return $this->insert($data);
    }
}
