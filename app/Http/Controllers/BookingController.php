<?php

namespace App\Http\Controllers;

use App\Models\TicketTable;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $__ticket;

    public function __construct(TicketTable $ticket)
    {
        $this->__ticket = $ticket;
    }

    /* 
        [GET]/ticket
    */
    public function listAction(Request $request)
    {
        $search = $request->all();
        $data   = $this->__ticket->getList($search);

        return view('ticket.list', ['data' => $data]);
    }

    /* 
        [GET]/ticket/details/{id}
    */
    public function viewTicketAction(Request $request)
    {
        $id = $request->id;
        $data = $this->__ticket->viewTicket($id);

        return view('ticket.details', ['data' => $data]);
    }

    /* 
        [POST]/ticket/update
        For admin to manually update the status of the ticket
    */
    public function updateStateAction(Request $request)
    {
        $state               = $request->except('_token');
        $state['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:00');

        try {
            $this->__ticket->updateState($state);
        } catch (Exception $ex) {
            return response()->json([
                'error'   => true,
                'message' => $ex->getMessage()
            ]);
        }
        return response()->json([
            'error'   => false,
            'message' => "OK!"
        ]);
    }
}
