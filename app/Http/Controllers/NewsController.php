<?php

namespace App\Http\Controllers;

use App\Models\CategoryTable;
use App\Models\NewsTable;
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

    public function newsListAction()
    {
        $data = $this->__news->getList();

        return view('news.list', ['data' => $data]);
    }

    public function addAction()
    {
        $cateTable = app(CategoryTable::class);
        $cate      = $cateTable->getCate();

        return view('news.add', ['cate' => $cate]);
    }

    public function storeAction(Request $request)
    {
        $news = $request->except('_token');
        $request->validate([
            'title'       => 'required',
            'content'     => 'required|min:160',
            'category_id' => 'required'
        ]);

        $news['author'] = auth()->user()->id;
        $news['created_at'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:00');
        $news['is_shown'] = 0;

        //dd($news);
        try {
            $this->__news->addNew($news);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return redirect("/news");

    }
}
