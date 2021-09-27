@extends('layout.master')
@section('content')
<section>
    <div class="d-flex bd-highlight mb-3">
        <div class="p-2 bd-highlight align-self-center">
            <h2 class="mb-3" style="padding-top: 15px;">Details ID: {{ $data['id']}}</h2>
        </div>
        <div class="p-2 align-self-center bd-highlight">
            @if($data['is_shown'] == 0)
            <span class="badge badge-success" name="is_shown">Published</span>
            @else
            <span class="badge badge-secondary" name="is_shown">Hidden</span>
            @endif
        </div>
        <div class="ml-auto p-2 bd-highlight align-self-center">
            <a href="{{route('news.list')}}"> << Return to list</a>
        </div>
    </div>

    <hr class="my-3">
    <div class="form-group">
        <div class="row">
            <div class="col">
                <label class="font-weight-bold">Title:</label>
                <p>{{ $data['title'] }}</p>
            </div>
            <div class="col">
                <label class="font-weight-bold">Author:</label>
                <p>{{ $data['fullname'] }}</p>
            </div>
            <div class="col">
                <label class="font-weight-bold">Category:</label>
                <p>{{ $data['cate_name'] }}</p>
            </div>
        </div>
        <label class="font-weight-bold">Content:</label>
        <p class="text-justify">{{ $data['content'] }}</p>

        <label class="font-weight-bold">Cover Photo:</label>
        @if(isset($data['photo']))
        <img src="{{$data['photo']}}" alt="">
        @else
        <p>No photo available</p>
        @endif
    </div>
</section>
@endsection