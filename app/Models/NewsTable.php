<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTable extends Model
{
    use HasFactory;
    protected $table = 'news';
    protected $primaryKey = 'id';
    protected $fillables = ['id', 'title', 'content', 'category_id', 'author', 'photo', 'created_at', 'updated_at', 'is_shown'];

    public function getList($search)
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
        if (!empty($search['query'])) {
            $data->where('news.title', 'LIKE', '%' . $search['query'] . '%')
                 ->orWhere('c.cate_name', 'LIKE', '%' . $search['query'] . '%')
                 ->orWhere('u.fullname', 'LIKE', '%' . $search['query'] . '%');
        }
        return $data->paginate(5);
    }

    public function addNews($data)
    {
        return $this->insert($data);
    }

    public function viewNews($id)
    {
        $data = $this->select(
            'news.id',
            'news.title',
            'news.content',
            'news.category_id',
            'news.author',
            'news.photo',
            'news.is_shown',
            'c.cate_name',
            'u.fullname',
        )
            ->leftjoin('category as c', 'news.category_id', '=', 'c.id')
            ->leftjoin('users as u', 'news.author', '=', 'u.id')
            ->where('news.id', $id);
        return $data->first();
    }

    public function getNewsById($id)
    {
        $data = $this->select(
            'news.id',
            'news.title',
            'news.content',
            'news.category_id',
            'news.author',
            'news.photo',
            'news.is_shown',
            'c.cate_name',
            'u.fullname',
        )
            ->leftjoin('category as c', 'news.category_id', '=', 'c.id')
            ->leftjoin('users as u', 'news.author', '=', 'u.id')
            ->where('news.id', $id);
        return $data->first();
    }

    public function updateNews($update)
    {
        return $this->where('news.id', $update['id'])
            ->update($update);
    }

    public function deleteNews($id)
    {
        return $this->where('news.id', $id)
            ->delete();
    }
}
