<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToursTable extends Model
{
    use HasFactory;
    protected $table = 'tours';
    protected $primaryKey = 'id';
    protected $fillables = ['id', 'tour_id', 'name', 'departure', 'return', 'price', 'vehicle', 'details', 'is_active', 'created_at', 'updated_at'];

    public function getList($search)
    {
        $data = $this->select(
            'id',
            'tour_id',
            'name',
            'departure',
            'return',
            'price',
            'vehicle',
            'details',
            'is_active',
            'created_at',
        );
        if (!empty($search['query'])) {
            $data->where('tour_id', '=', $search['query'])
                 ->orWhere('name', 'LIKE', '%' . $search['query'] . '%');
        }
        if (!empty($search['status'])) {
            $data->where('is_active', $search['status']);
        }
        if (!empty($search['departure'])) {
            $data->whereBetween('departure', [$search['departure'], $search['return']]);
        }
        if (!empty($search['return'])) {
            $data->whereBetween('return', [$search['departure'], $search['return']]);
        }

        return $data->paginate(5);
    }

    public function addTour($data)
    {
        return $this->insert($data);
    }

    public function viewTour($id)
    {
        $data = $this->select(
            'id',
            'tour_id',
            'name',
            'departure',
            'return',
            'price',
            'vehicle',
            'details',
            'is_active',
        )
            ->where('id', $id);
        return $data->first();
    }

    public function getTourById($id)
    {
        $data = $this->select(
            'id',
            'tour_id',
            'name',
            'departure',
            'return',
            'price',
            'vehicle',
            'details',
            'is_active',
        )
            ->where('id', $id);
        return $data->first();
    }

    public function updateTour($update)
    {
        return $this->where('id', $update['id'])
            ->update($update);
    }

    public function deleteTour($id)
    {
        return $this->where('id', $id)
            ->delete();
    }
}