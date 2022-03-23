<?php

namespace App\Http\Controllers;

use App\Models\ToursTable;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function addTourAction()
    {
        return view('tours.add');
    }

    public function storeTourAction(Request $request) //storeTourInput
    {
        $tour = $request->except('_token');
        $request->validate([
            'name'      => 'required',
            'departure' => 'required',
            'return'    => 'required',
            'price'     => 'required',
            'vehicle'   => 'required',
            'details'   => 'min:160',
            'slots'     => 'required'
        ]);

        $tour['tour_code'] = Str::random(6);
        $tour['created_at'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:00');

        try {
            $this->__tour->addTour($tour);
        } catch (Exception $ex) {
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

    public function editTourAction(Request $request)
    {
        $id        = $request->id;
        $data      = $this->__tour->getTourById($id);

        return view('tours.edit', ['data' => $data]);
    }

    public function updateTourAction(Request $request)
    {
        $tour               = $request->except('_token');
        $tour['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:00');

        try {
            $this->__tour->updateTour($tour);
        } catch (Exception $ex) {
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

    public function deleteTourAction(Request $request)
    {
        $id = $request->id;

        try {
            $this->__tour->deleteTour($id);
        } catch (Exception $ex) {
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
