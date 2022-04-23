<?php
$role = auth()->user()->role;
?>
@extends($role ==="Admin" ? 'layout.master' : 'layout.collab-layout')
@section('content')
<section style="height: 470px">
    <h2 class="mb-3" style="padding-top: 15px;">Change Password</h2>
    <hr class="my-3">
    <div class="" style="width: 50%">
        <form id="form-data">
            <input type="text" name="id" value="{{$data['id']}}" hidden>
            <div class="form-group row">
                <label for="password" class="col-sm-6 col-form-label font-weight-bold">New Password: <span class="error">*</span></label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" name="password" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="confirmpw" class="col-sm-6 col-form-label font-weight-bold">Confirm Password: <span class="error">*</span></label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" name="password_confirmation" autocomplete="off">
                </div>
            </div>
            <div class="p-2 bd-highlight">
                <button type="button" id="submitbtn" class="btn btn-primary">Change</button>
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
                password: {
                    required: true,
                    minlength: 6,
                },
                password_confirmation: {
                    required: true,
                    equalTo: '[name="password"]'
                },
            },
            messages: {
                password: {
                    required: 'Password must not be empty',
                    minlength: 'At least 6 characters'
                },
                password_confirmation: {
                    required: 'Confirmation is required',
                    equalTo: 'Password is not match'
                },
            }
        });
        //if form valid -> call ajax
        if (form.valid()) {
            $('#submitbtn').attr('disabled', true);
            $.ajax({
                url: '{{ route("admin.confirmchange") }}',
                type: 'POST',
                data: form.serialize(),
                success: function(res) {
                    if (res.error === false) {
                        swal.fire(res.message, '', "success").then(function() {
                            window.location.href = "{{ route('admin.changepw', $data['id'])}}";
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
                        swal.fire('Fail to change password failed!', mess_error, "error").then(function() {
                            $('#submitbtn').attr('disabled', false);
                        });
                    }
                }
            });
        }
    });
</script>
@endsection