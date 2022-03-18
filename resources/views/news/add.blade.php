@extends('layout.master')
@section('content')
<section class="content">
    <div class="d-flex bd-highlight mb-3" style="padding-top: 15px;">
        <div class="p-2 bd-highlight align-self-center">
            <h2 class="mb-3" >New Content</h2>
        </div>
        <div class="ml-auto p-2 bd-highlight align-self-center">
            <a href="{{route('news.list')}}"> << Return to list</a>
        </div>
    </div>
    <hr class="my-3">
    <div class="form-group">
        <form id="form-data">
            @csrf
            <div class="row">
                <!-- Title -->
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Title:<span class="error">*</span>
                        </div>
                        <input type="text" class="form-control" name="title" placeholder="News title here..." aria-describedby="basic-addon1">
                    </div>
                </div>
                <!-- Category -->
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Category:<span class="error">*</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01" name="category_id">
                            <option value="" hidden>Select one...</option>
                            @foreach($cate as $cateItem)
                            <option value="{{ $cateItem['id'] }}">{{ $cateItem['cate_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- Content -->
            <textarea type="text" name="content" class="form-control" placeholder="Write something..." rows="10" style="resize:none"></textarea> <br>

            <!-- Button group -->
            <div class="form-group d-flex justify-content-center">
                <button type="button" id="submit-content" class="btn btn-primary btn-lg">Create</button>
                <button type="button" class="btn btn-link btn-lg" onclick="window.location='{{ route('news.list') }}'">Cancel</button>
            </div>
        </form>
    </div>
</section>
@endsection
@section('after_script')
<script type="text/javascript">
    $(document).ready(function() {
        //trigger button add
        $('#submit-content').click(function() {
            //trigger form add
            var form = $('#form-data');
            //setup csrf
            $.ajaxSetup({
                headers: {
                    //get csrf form content of meta tag
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //validate form
            form.validate({
                rules: {
                    title: {
                        required: true,
                    },
                    content: {
                        required: true,
                        minlength: 160,
                    },
                    category_id: {
                        required: true,
                    },           
                },
                messages: {
                    title: {
                        required: 'News title is required',
                    },
                    content: {
                        required:  'Content is required',
                        minlength: 'Content must be at least 160 characters',
                    },
                    category_id: {
                        required: 'Category is required',
                    },              
                }
            });
            //if form valid -> call ajax
            if (form.valid()) {
                //disable button add prevent dup click
                $('#submit-content').attr('disabled', true);
                $.ajax({
                    url: '{{ route("news.store") }}',
                    type: 'POST',
                    data: form.serialize(),
                    success: function(res) {
                        if (res.error === false) {
                            swal.fire(res.message, '', "success").then(function() {
                                window.location.href = "{{ route('news.list')}}";
                                
                            });
                        } else {
                            swal.fire(res.message, '', "error").then(function() {
                                $('#submit-content').attr('disabled', false);
                            });
                        }
                    },
                    error: function(res) {
                        if (res.responseJSON != undefined) {
                            var mess_error = '';
                            $.map(res.responseJSON.errors, function(a) {
                                mess_error = mess_error.concat(a + '<br/>');
                            });
                            swal.fire('Fail to add new content!', mess_error, "error").then(function() {
                                $('#submit-content').attr('disabled', false);
                            });
                        }
                    }
                });
            }
        });
    })
</script>
@endsection