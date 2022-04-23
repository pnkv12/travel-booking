<?php
$role = auth()->user()->role;
?>
@extends($role ==="Admin" ? 'layout.master' : 'layout.collab-layout')
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
            <a href="{{route('news.list')}}">
                << Return to list</a>
        </div>
    </div>

    <hr class="my-3">
    <div class="form-group">
        @if ($data['photo_id']== 0)
        <p>No photo available</p>
        @else
        <img src="{{asset('storage/image/'.$data['photo_name'])}}" width="100%" />
        @endif
        <hr>
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
        <p class="text-justify pb-5">{!! nl2br(e($data['content']))!!}</p>

    </div>
</section>
@endsection