<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToursTable extends Model
{
    use HasFactory;

    protected $table = 'tours';
    protected $primaryKey = 'id';
    protected $fillables = ['id', 'photo_id', 'tour_code', 'name', 'departure', 'return', 'price', 'vehicle', 'details', 'slots', 'created_at', 'updated_at'];

    public function getList($search)
    {
        $data = $this->select(
            'id',
            'photo_id',
            'tour_code',
            'name',
            'departure',
            'return',
            'price',
            'vehicle',
            'details',
            'slots',
            'created_at',
        );
        if (!empty($search['query'])) {
            $data->where('tour_code', '=', $search['query'])
                ->orWhere('name', 'LIKE', '%' . $search['query'] . '%');
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
            'tours.id',
            'tours.photo_id',
            'tours.tour_code',
            'tours.name',
            'tours.departure',
            'tours.return',
            'tours.price',
            'tours.vehicle',
            'tours.details',
            'tours.slots',
            'i.photo_id',
            'i.photo_name'
        )
            ->leftjoin('images as i', 'tours.photo_id', '=', 'i.photo_id')
            ->where('id', $id);
        return $data->first();
    }

    public function getTourById($id)
    {
        $data = $this->select(
            'tours.id',
            'tours.photo_id',
            'tours.tour_code',
            'tours.name',
            'tours.departure',
            'tours.return',
            'tours.price',
            'tours.vehicle',
            'tours.details',
            'tours.slots',
            'i.photo_id',
            'i.photo_name'
        )
            ->leftjoin('images as i', 'tours.photo_id', '=', 'i.photo_id')
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
