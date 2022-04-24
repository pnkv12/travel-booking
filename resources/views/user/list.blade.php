<?php
$role = auth()->user()->role;
if ($role === "Collab") {
    echo "You're not allowed, please go back.";
    return redirect()->back();
};
?>
@extends('layout.master')
@section('content')
<style>
    #edit-role:hover {
        color: blue;
        cursor: pointer;
    }
</style>
<section style="height: 35em;">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="mb-3" style="padding-top: 15px;">Contacts</h2>
        </div>
        <div class="d-flex align-self-end">
            <form method="GET" action="" class="form-group">
                <div class="form-row">
                    <div class="input-group rounded">
                        <input type="text" name="query" class="form-control rounded" placeholder="Search" aria-describedby="search-addon" />
                        <span id="search-addon">
                            <button type="submit" class="btn btn-link text-info"><i class="fas fa-search"></i></button>
                        </span>
                        <button type="button" class="btn btn-link text-secondary" onclick="window.location.href='{{ route("admin.list") }}'"><i class="fas fa-undo-alt"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <hr class="my-3">
    <?php
    ?>
    <div class="table-content" style="padding-top: 9px;">
        <table class="table table-striped">
            <thead class="bg-info text-light text-center">
                <th>Admin</th>
                <th scope="col">Fullname</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Role</th>
                <th></th>
            </thead>
            <tbody>
                @if(isset($data))
                @foreach($data as $item)
                <tr>
                    <td scope="row" class="text-center">{{$item['id']}}</td>
                    <td scope="row">{{$item['fullname']}}</td>
                    <td scope="row">{{$item['username']}}</td>
                    <td scope="row"> <a href="#">{{$item['email']}}</a></td>
                    <td scope="row" class="text-center">{{$item['phone']}}</td>
                    <td scope="row" id="edit-role" class="text-center" data-toggle="modal" data-target="#change-role_{{ $item['id'] }}">{{$item['role']}}</td>

                    <td scope="row"><button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete_{{ $item['id'] }}"><i class="fas fa-trash-alt"></i></button></td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td scope="row" style="pointer-events: none;">No data</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Delete confirm modal -->
    @foreach($data as $item)
    <div class="modal fade" id="confirm-delete_{{ $item['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    This action cannot be undone
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary delete-user" data-id="{{ $item['id'] }}">Confirm</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Change Role popup -->
    @foreach($data as $item)
    <div class="modal fade" id="change-role_{{ $item['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change this user's role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="changeRole">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item['id'] }}" id="user-id">
                        <select name="role" id="role" class="custom-select">
                            <option value="Admin" <?php if ($item['role'] === "Admin") echo 'selected';
                                                    else echo ''; ?>>Admin</option>
                            <option value="Collab" <?php if ($item['role'] === "Collab") echo 'selected';
                                                    else echo ''; ?>>Collab</option>
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" form="changeRole" class="btn btn-primary confirm-role" data-id="{{ $item['id'] }}">Confirm</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <span class="d-flex flex-row-reverse">{{ $data->links() }}</span>
</section>
@endsection

@section('after_script')
<script type="text/javascript">
    $(document).ready(function() {
        //Trigger nhấn nút xóa
        $(".delete-user").click(function() {

            var id = $(this).data("id"); //Lấy id

            var url = '{{ route("admin.delete", ":id") }}';
            url = url.replace(':id', id);
            //Setup AJAX csrf token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //Call AJAX
            $.ajax({
                url: url,
                type: 'DELETE',
                data: id,
                success: function(res) {
                    if (res.error === false) {
                        swal.fire(res.message, '', "success").then(function() {
                            location.reload();
                        });
                    } else {
                        swal.fire(res.message, '', "error");
                    }
                },
                error: function(res) {
                    if (res.responseJSON != undefined) {
                        var mess_error = '';
                        $.map(res.responseJSON.errors, function(a) {
                            mess_error = mess_error.concat(a + '<br/>');
                        });
                        swal.fire('Delete failed!', mess_error, "error");
                    }
                }
            });
        });

        // Trigger change role
        $('.confirm-role').click(function() {
            //trigger form data
            var form = $('.changeRole');

            //setup csrf for ajax
            $.ajaxSetup({
                headers: {
                    //get csrf from content of meta tag
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (form.valid()) {
                $('.confirm-role').attr('disabled', true);
                $.ajax({
                    url: '{{ route("admin.changerole") }}',
                    type: 'POST',
                    data: form.serialize(),
                    success: function(res) {
                        if (res.error === false) {
                            swal.fire(res.message, '', "success").then(function() {
                                $('.changeRole').trigger("reset");
                                window.location.reload(true);
                            });
                        } else {
                            swal.fire(res.message, '', "error").then(function() {
                                $('.confirm-role').attr('disabled', false);
                            });
                        }
                    },
                    error: function(res) {
                        if (res.responseJSON != undefined) {
                            var mess_error = '';
                            $.map(res.responseJSON.errors, function(a) {
                                mess_error = mess_error.concat(a + '<br/>');
                            });
                            swal.fire('Role failed to change!', mess_error, "error").then(function() {
                                $('.confirm-role').attr('disabled', false);
                            });
                        }
                    }
                });
            }
        });
    });
</script>
@endsection