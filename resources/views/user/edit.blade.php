@extends('layout.master')
@section('content')
<section style="height: 470px">
        <h2 class="mb-3" style="padding-top: 15px;">Your profile:  <span class="text-info">{{$data['username']}}</span></h2>
    <hr class="my-3">
    <form id="form-data" style="width:50%">
        @csrf
        <input type="text" name="id" value="{{$data['id']}}" hidden>
        <div>
            <label class="font-weight-bold" for="fullname">Fullname: &nbsp;</label>
            <input type="text" id="fullname" class="form-control" name="fullname" value="{{$data['fullname']}}" placeholder="Fullname...">
        </div>
        <div>
            <label class="font-weight-bold" for="email">Email: &nbsp;</label>
            <input type="text" id="email" class="form-control" name="email" value="{{$data['email']}}" placeholder="Email...">
        </div>
        <div>
            <label class="font-weight-bold" for="phone">Phone: &nbsp;</label>
            <input type="text" id="phone" class="form-control" name="phone" value="{{$data['phone']}}" placeholder="Phone...">
        </div>
        <div class="p-2 bd-highlight">
            <button type="button" id="submitbtn" class="btn btn-primary">Done</button>
            <button type="button" class="btn btn-secondary" onclick="window.location=' {{ route('admin.profile', $data['id']) }} '">Cancel</button>
        </div>
    </form>
</section>
@endsection
@section('after_script')
<script type="text/javascript">
    //trigger button update
    $('#submitbtn').click(function() {
        //trigger form data
        var form = $('#form-data');

        //setup csrf for ajax
        $.ajaxSetup({
            headers: {
                //get csrf from content of meta tag
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        form.validate({
            rules: {
                fullname: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                phone: {
                    required: true,
                    digits: 10
                },
            },
            messages: {
                fullname: {
                    required: 'This is required',
                },
                email: {
                    required: 'This is required', 
                    email: 'Incorrect email format'
                },
                phone: {
                    required: 'This is required', 
                    digits: 'Must be 10 digits'
                },
            }
        });
        //if form valid -> call ajax
        if (form.valid()) {
            $('#submitbtn').attr('disabled', true);
            $.ajax({
                url: '{{ route("admin.update") }}',
                type: 'POST',
                data: form.serialize(),
                success: function(res) {
                    if (res.error === false) {
                        swal.fire(res.message, '', "success").then(function() {
                            window.location.href = "{{ route('admin.profile', $data['id'] )}}";
                        });
                    } else {
                        swal.fire(res.message, '', "error").then(function() {
                            $('#submitbtn').attr('disabled', false);
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
                            $('#submitbtn').attr('disabled', false);
                        });
                    }
                }
            });
        }
    });
</script>
@endsection