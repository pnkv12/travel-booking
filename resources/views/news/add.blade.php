@extends('layout.master')
@section('content')
<section>
    <h2 class="mb-3" style="padding-top: 15px;">New Content</h2>
    <hr class="my-3">
    <div class="form-group">
        <form method="POST" action="{{ route('news.store') }}">
            @csrf
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="row">
                <div class="col">
                    <label class="font-weight-bold">Title:<span class="error">*</label>
                    <input type="text" name="title" class="form-control" placeholder="News title here...">
                </div>
                <div class="col">
                    <label class="font-weight-bold">Category:<span class="error">*</label>
                    <select class="form-control" name="category_id">
                        <option value="" hidden>Select one...</option>
                        @foreach($cate as $cateItem)
                        <option value="{{ $cateItem['id'] }}">{{ $cateItem['cate_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div> <br>

            <textarea type="text" name="content" class="form-control" placeholder="Write something..." rows="10" style="resize:none" required></textarea> <br>
            <div class="col">
                    <label class="font-weight-bold">Cover Photo:</label>
                    <input type="file" class="form-control-file" name="photo" id="cover_photo" accept="jpeg, jpg, png|image/*">
                </div>
            <div class="form-group d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-lg">Create</button>
            </div>
        </form>
    </div>
</section>
@endsection