@extends('layout.master')
@section('content')
<section>
    <h2 class="mb-3" style="padding-top: 15px;">News List <a href="{{ route('news.add') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></a></h2>
    <hr class="my-3">
    <div class="table-content" style="padding-top: 9px;">
        <table class="table table-striped">
            <thead class="bg-info text-light">
                <th scope="col">ID</th>
                <th scope="col">Cover</th>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Category</th>
                <th scope="col">Author</th>
                <th scope="col">Created At</th>
                <th scope="col">Status</th>
                <th scope="col"> </th>
            </thead>
            <tbody>
                @if(!empty($data))
                @foreach($data as $item)
                <tr>
                    <td scope="row">{{$item['id']}}</td>

                    @if(!empty($item['photo']))
                    <td scope="row">{{$item['photo']}}</td>
                    @else
                    <td scope="row">N/A</td>
                    @endif
                    
                    <td scope="row">{{$item['title']}}</td>
                    <td scope="row"><small>{{Str::limit($item['content'], 50)}}</small></td>
                    <td scope="row">{{$item['cate_name']}}</td>
                    <td scope="row">{{$item['fullname']}}</td>
                    <td scope="row"><small>{{$item['created_at']}}</small></td>

                    @if($item['is_shown'] == 0)
                    <td scope="row" style="cursor: default;"><span class="badge bg-success text-light">Published</span></td>
                    @else
                    <td scope="row" style="cursor: default;"><span class="badge bg-secondary text-light">Hidden</span></td>
                    @endif

                    <td scope="row">
                        <div class="dropdown">
                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="cursor: pointer;">
                                <a class="dropdown-item" onclick="window.location='#'" class="btn btn-secondary"><i class="fa fa-info-circle" aria-hidden="true"></i> Read</a>
                                <a class="dropdown-item" onclick="window.location='#'" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
                                <a class="dropdown-item" data-id="{{ $item[''] }}"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td>Empty data</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <span class="d-flex flex-row-reverse">{{ $data->links() }}</span>
</section>
@endsection