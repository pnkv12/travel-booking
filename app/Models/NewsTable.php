<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTable extends Model
{
    use HasFactory;
    protected $table = 'news';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'title', 'content', 'category_id', 'author', 'photo_id', 'created_at', 'updated_at', 'is_shown', 'views'];

    public function getList($search)
    {
        $data = $this->select(
            'news.id',
            'news.title',
            'news.content',
            'news.category_id',
            'news.author',
            'news.created_at',
            'news.is_shown',
            'c.cate_name',
            'u.fullname',
            'u.username',
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
        return $this->create($data)->{$this->primaryKey};
    }

    public function viewNews($id)
    {
        $data = $this->select(
            'news.id',
            'news.title',
            'news.content',
            'news.category_id',
            'news.photo_id',
            'news.author',
            'news.is_shown',
            'c.cate_name',
            'u.fullname',
            'u.username',
            'i.photo_name'
        )
            ->leftjoin('category as c', 'news.category_id', '=', 'c.id')
            ->leftjoin('users as u', 'news.author', '=', 'u.id')
            ->leftjoin('images as i', 'news.photo_id', '=', 'i.photo_id')
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
            'news.photo_id',
            'news.is_shown',
            'c.cate_name',
            'u.fullname',
            'i.photo_id',
            'i.photo_name',
        )
            ->leftjoin('category as c', 'news.category_id', '=', 'c.id')
            ->leftjoin('users as u', 'news.author', '=', 'u.id')
            ->leftjoin('images as i', 'news.photo_id', '=', 'i.photo_id')
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
        return $this->where('news.id', $id)->first()
            ->delete();
    }
}
