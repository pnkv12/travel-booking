@extends('layout.master')
@section('content')
<section>
    <div class="d-flex bd-highlight mb-3" style="padding-top: 15px;">
        <div class="p-2 bd-highlight align-self-center">
            <h2 class="mb-3">Edit package ID: {{$data['id']}}</h2>
        </div>
        <div class="ml-auto p-2 bd-highlight align-self-center">
            <a href="{{route('news.list')}}">
                << Return to list</a>
        </div>
    </div>
    <hr class="my-3">
    <div class="form-group">
        <form id="form-data">
            @csrf
            <input name="id" value="{{ $data['id'] }}" hidden>

            <div class="form-row">
                <!--Package Name-->
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Package Name:</span>
                        </div>
                        <input type="text" class="form-control" name="name" aria-describedby="basic-addon1" value="{{$data['name']}}">
                    </div>
                </div>
                <!-- Price -->
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">$</span>
                        </div>
                        <input type="number" step=".01" class="form-control" name="price" aria-describedby="basic-addon1" value="{{$data['price']}}">
                    </div>
                </div>
                <!--Status-->
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Status:</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01" name="is_active">
                            <option value="0" <?php if ($data['is_active'] == 0) echo 'selected';
                                                else echo ''; ?>>Available</option>
                            <option value="1" <?php if ($data['is_active'] == 1) echo 'selected';
                                                else echo ''; ?>>Sold Out</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Departure -->
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Departure Date:</span>
                        </div>
                        <input type="date" class="form-control" name="departure" aria-describedby="basic-addon1" min="2021-09-01" value="{{$data['departure']}}">
                    </div>
                </div>
                <!-- Return -->
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Return Date:</span>
                        </div>
                        <input type="date" class="form-control" name="return" aria-describedby="basic-addon1" min="2021-09-01" value="{{$data['return']}}">
                    </div>
                </div>
                <!-- Vehicle -->
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Travel By:</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01" name="vehicle">
                            <option value="0" <?php if ($data['vehicle'] == 0) echo 'selected';
                                                else echo ''; ?>>Plane</option>
                            <option value="1" <?php if ($data['vehicle'] == 1) echo 'selected';
                                                else echo ''; ?>>Bus</option>
                            <option value="2" <?php if ($data['vehicle'] == 2) echo 'selected';
                                                else echo ''; ?>>Ship</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Details -->
            <textarea type="text" name="details" class="form-control" rows="10" style="resize:none">{{ nl2br($data['details']) }}</textarea> <br>
            <!--Button group-->
            <div class="form-group d-flex justify-content-center">
                <button type="button" id="submit" class="btn btn-primary btn-lg">Update</button>
                <button type="button" class="btn btn-link btn-lg" onclick="window.location='{{route('tours.list')}}'">Cancel</button>
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
                url: '{{ route("tours.update") }}',
                type: 'POST',
                data: form.serialize(),
                success: function(res) {
                    if (res.error === false) {
                        swal.fire(res.message, '', "success").then(function() {
                            window.location.href = "{{ route('tours.list')}}";
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