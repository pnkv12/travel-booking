<?php

namespace App\Http\Controllers;

use App\Models\CategoryTable;
use App\Models\NewsTable;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $__news;

    public function __construct(NewsTable $news)
    {
        $this->__news = $news;
    }

    public function newsListAction(Request $request)
    {
        $search = $request->all();
        $data   = $this->__news->getList($search);

        return view('news.list', ['data' => $data]);
    }

    public function addNewsAction()
    {
        $cateTable = app(CategoryTable::class);
        $cate      = $cateTable->getCate();

        return view('news.add', ['cate' => $cate]);
    }

    public function storeNewsAction(Request $request)
    {
        $news = $request->except('_token');

        $request->validate([
            'title'       => 'required',
            'content'     => 'required|min:160',
            'category_id' => 'required'
        ]);



        $news['author']     = auth()->user()->id;
        $news['created_at'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:00');
        $news['is_shown']   = 0;

        try {
            $this->__news->addNews($news);
        } catch (Exception $ex) {
            return response()->json([
                'error'   => true,
                'message' => $ex->getMessage()
            ]);
        }
        return response()->json([
            'error'   => false,
            'message' => "Ayyy, content added to the system!"
        ]);
    }

    public function viewNewsAction(Request $request)
    {
        $id   = $request->id;
        $data = $this->__news->viewNews($id);

        return view('news.details', ['data' => $data]);
    }

    public function editNewsAction(Request $request)
    {
        $id        = $request->id;
        $data      = $this->__news->getNewsById($id);

        $cateTable = app(CategoryTable::class);
        $cate      = $cateTable->getCate();

        return view(
            'news.edit',
            [
                'data' => $data,
                'cate' => $cate
            ]
        );
    }

    public function updateNewsAction(Request $request)
    {
        $news               = $request->except('_token');
        $news['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:00');

        try {
            $this->__news->updateNews($news);
        } catch (Exception $ex) {
            return response()->json([
                'error'   => true,
                'message' => $ex->getMessage()
            ]);
        }
        return response()->json([
            'error'   => false,
            'message' => "Yippi~ Content updated!"
        ]);
    }

    public function deleteNewsAction(Request $request)
    {
        $id = $request->id;

        try {
            $this->__news->deleteNews($id);
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
