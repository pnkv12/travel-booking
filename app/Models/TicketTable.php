<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketTable extends Model
{
    use HasFactory;
    protected $table = 'booking-ticket';
    protected $primaryKey = 'ticket_id';
    protected $fillables = ['ticket_id', 'cus_id', 'phone', 'tour_id', 'state', 'total_price', 'created_at', 'updated_at'];

    public function getList($search)
    {
        $data = $this->select(
            'booking-ticket.ticket_id',
            'booking-ticket.cus_id',
            'booking-ticket.phone',
            'booking-ticket.tour_id',
            'booking-ticket.state',
            'booking-ticket.created_at',
            'booking-ticket.total_price',
            't.tour_code',
            'c.firstname',
            'c.lastname',
            'c.phone',
            'c.email',
            'c.address',
            'c.notes'
        )
            ->leftjoin('tours as t', 'booking-ticket.tour_id', '=', 't.id')
            ->leftjoin('customers as c', 'booking-ticket.cus_id', '=', 'c.cus_id');

        if (!empty($search['query'])) {
            $data->where('c.firstname', 'LIKE', '%' . $search['query'] . '%')
                ->orWhere('c.lastname', 'LIKE', '%' . $search['query'] . '%')
                ->orWhere('c.phone', 'LIKE', '%' . $search['query'] . '%')
                ->orWhere('t.tour_code', 'LIKE', '%' . $search['query'] . '%');
        }
        if (!empty($search['state'])) {
            $data->where('booking-ticket.state', $search['state']);
        }
        return $data->paginate(5);
    }

    public function viewTicket($id)
    {
        $data = $this->select(
            'booking-ticket.ticket_id',
            'booking-ticket.cus_id',
            'booking-ticket.phone',
            'booking-ticket.tour_id',
            'booking-ticket.state',
            'booking-ticket.total_price',
            't.tour_code',
            'c.firstname',
            'c.lastname',
            'c.phone',
            'c.email',
            'c.address',
            'c.members',
            'c.notes'
        )
            ->leftjoin('tours as t', 'booking-ticket.tour_id', '=', 't.id')
            ->leftjoin('customers as c', 'booking-ticket.cus_id', '=', 'c.cus_id')
            ->where('booking-ticket.ticket_id', $id);
        return $data->first();
    }

    public function updateState($update)
    {
        return $this->where('booking-ticket.ticket_id', $update['ticket_id'])
            ->update($update);
    }
}
