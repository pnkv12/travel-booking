<?php

namespace App\Http\Controllers;

use App\Models\ToursTable;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ToursController extends Controller
{
    protected $__tour;

    public function __construct(ToursTable $tour)
    {
        $this->__tour = $tour;
    }

    public function tourListAction(Request $request)
    {
        $search = $request->all();
        $data = $this->__tour->getList($search);

        return view('tours.list', ['data' => $data]);
    }

    public function addAction()
    {
        return view('tours.add');
    }

    public function storeAction(Request $request)
    {
        $tour = $request->except('_token');
        $request->validate([
            'tour_id'   => 'required|unique:tours',
            'name'      => 'required',
            'departure' => 'required',
            'return'    => 'required',
            'price'     => 'required',
            'vehicle'   => 'required',
            'details'   => 'min:160',
        ]);
        $tour['is_active']  = 0;
        $tour['created_at'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:00');

        try {
            $this->__tour->addTour($tour);
        }
        catch (Exception $ex) {
            return response()->json([
                'error'   => true,
                'message' => $ex->getMessage()
            ]);
        }
        return response()->json([
            'error'   => false,
            'message' => "Ayyy, package added to the system!"
        ]);
    }

    public function viewTourAction(Request $request)
    {
        $id = $request->id;
        $data = $this->__tour->viewTour($id);

        return view('tours.details', ['data' => $data]);
    }

    public function editAction(Request $request)
    {
        $id        = $request->id;
        $data      = $this->__tour->getTourById($id);

        return view('tours.edit', ['data' => $data]);
    }

    public function updateAction(Request $request)
    {
        $tour               = $request->except('_token');
        $tour['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:00');

        try {
            $this->__tour->updateTour($tour);
        } 
        catch (Exception $ex) {
            return response()->json([
                'error'   => true,
                'message' => $ex->getMessage()
            ]);
        }
        return response()->json([
            'error'   => false,
            'message' => "Yippi~ Package updated!"
        ]);
    }

    public function deleteAction(Request $request)
    {
        $id = $request->id;

        try {
            $this->__news->deleteTour($id);
        } 
        catch (Exception $ex) {
            return response()->json([
                'error'   => true,
                'message' => $ex->getMessage()
            ]);
        }
        return response()->json([
            'error'   => false,
            'message' => "Worry not, it's deleted successfully!"
        ]);
    }
}
