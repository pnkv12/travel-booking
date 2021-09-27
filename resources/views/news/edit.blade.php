@extends('layout.master')
@section('content')
<section>
    <div class="d-flex bd-highlight mb-3" style="padding-top: 15px;">
        <div class="p-2 bd-highlight align-self-center">
            <h2 class="mb-3" >Edit content ID: {{$data['id']}}</h2>
        </div>
        <div class="ml-auto p-2 bd-highlight align-self-center">
            <a href="{{route('news.list')}}"> << Return to list</a>
        </div>
    </div>
    <hr class="my-3">
    <div class="form-group">
        <form id="form-data">
            @csrf
            <input name="id" value="{{ $data['id'] }}" hidden>

            <div class="row">
                <!--Title-->
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Title:</span>
                        </div>
                        <input type="text" class="form-control" name="title" placeholder="News title here..." aria-describedby="basic-addon1" value="{{$data['title']}}">
                    </div>
                </div>
                <!--Category-->
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Category:</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01" name="category_id">
                            @if(isset($cate))
                            @foreach($cate as $cateItem)
                            <option value="{{ $cateItem['id'] }}" {{ $cateItem['id'] == $data['category_id'] ? 'selected' : '' }}>
                                {{ $cateItem['cate_name'] }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            
            <!--Content-->
            <textarea type="text" name="content" class="form-control" rows="10" style="resize:none">{{ nl2br($data['content']) }}</textarea> <br>
            
            <!--Cover photo-->
            @if(isset($data['photo']))
            <label class="font-weight-bold">Cover Photo:</label>
            <input type="file" class="form-control-file" name="photo" accept="jpeg, jpg, png|image/*" value="{{$data['photo']}}">
            @else
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="custom-file-label" id="inputGroupFileAddon01">Choose a photo</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="photo" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" accept="jpeg, jpg, png|image/*">
                </div>
            </div>
            @endif
            
            <!--Button group-->
            <div class="form-group d-flex justify-content-center">
                <button type="button" id="submit" class="btn btn-primary btn-lg">Update</button>
                <button type="button" class="btn btn-link btn-lg" onclick="window.location='{{route('news.list')}}'">Cancel</button>
            </div>
        </form>
    </div>
</section>
@endsection
@section('after_script')
<script type="text/javascript">
    //trigger button update
    $('#submit').click(function() {
        //trigger form data
        var form = $('#form-data');

        //setup csrf for ajax
        $.ajaxSetup({
            headers: {
                //get csrf from content of meta tag
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //if form valid -> call ajax
        if (form.valid()) {
            $('#submit').attr('disabled', true);
            $.ajax({
                url: '{{ route("news.update") }}',
                type: 'POST',
                data: form.serialize(),
                success: function(res) {
                    if (res.error === false) {
                        swal.fire(res.message, '', "success").then(function() {
                            window.location.href = "{{ route('news.list')}}";
                        });
                    } else {
                        swal.fire(res.message, '', "error").then(function() {
                            $('#submit').attr('disabled', false);
                        });
                    }
                },
                error: function(res) {
                    if (res.responseJSON != undefined) {
                        var mess_error = '';
                        $.map(res.responseJSON.errors, function(a) {
                            mess_error = mess_error.concat(a + '<br/>');
                        });
                        swal.fire('Updated failed!', mess_error, "error").then(function() {
                            $('#submit').attr('disabled', false);
                        });
                    }
                }
            });
        }
    });
</script>
@endsection