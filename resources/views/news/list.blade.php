<?php
$role = auth()->user()->role;
$username = auth()->user()->username;
?>

@extends($role ==="Admin" ? 'layout.master' : 'layout.collab-layout')
@section('content')
<section style="height: 40em">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="mb-3" style="padding-top: 15px;">News List <a href="{{ route('news.add') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></a></h2>
        </div>
        <div class="d-flex align-self-end">
            <form method="GET" role="search" class="form-group">
                <div class="form-row">
                    <div class="input-group rounded">
                        <input type="text" name="query" class="form-control rounded" placeholder="Search" aria-describedby="search-addon" />
                        <span id="search-addon">
                            <button type="submit" class="btn btn-link text-info"><i class="fas fa-search"></i></button>
                        </span>
                        <button type="button" class="btn btn-link text-secondary" onclick="window.location.href='{{ route("news.list") }}'"><i class="fas fa-undo-alt"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr class="my-3">
    <div class="table-content" style="padding-top: 9px;">
        <table class="table table-hover">
            <thead class="bg-info text-light">
                <th scope="col">ID</th>
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
                    <td scope="row" onclick="window.location='{{ route("news.details", $item['id']) }}'" style="cursor: pointer">{{$item['id']}}</td>
                    <td scope="row" onclick="window.location='{{ route("news.details", $item['id']) }}'" style="cursor: pointer">{{$item['title']}}</td>
                    <td scope="row" onclick="window.location='{{ route("news.details", $item['id']) }}'" style="cursor: pointer"><small>{{Str::limit($item['content'], 50)}}</small></td>
                    <td scope="row" onclick="window.location='{{ route("news.details", $item['id']) }}'" style="cursor: pointer">{{$item['cate_name']}}</td>
                    <td scope="row" onclick="window.location='{{ route("news.details", $item['id']) }}'" style="cursor: pointer">{{$item['fullname']}}</td>
                    <td scope="row" onclick="window.location='{{ route("news.details", $item['id']) }}'" style="cursor: pointer"><small>{{$item['created_at']}}</small></td>


                    @if($item['is_shown'] == 0)
                    <td scope="row" style="cursor: default;"><span class="badge bg-success text-light">Published</span></td>
                    @else
                    <td scope="row" style="cursor: default;"><span class="badge bg-secondary text-light">Hidden</span></td>
                    @endif

                    @if ($username === $item['username'] || $role === 'Admin')
                    <td scope="row">
                        <div class="dropdown">
                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="cursor: pointer;">
                                <a class="dropdown-item" onclick="window.location=' {{ route("news.edit", $item['id']) }} '" class="btn btn-info"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item text-danger" data-toggle="modal" data-target="#confirm-delete_{{ $item['id'] }}"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                    @endif
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

    @foreach($data as $item)
    <!-- Confirm delete news with modal -->
    <div class="modal fade" id="confirm-delete_{{ $item['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure {{ $item['id'] }}?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    This action cannot be undone
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary delete-news" data-id="{{ $item['id'] }}">Confirm</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</section>
@endsection
@section('after_script')
<script type="text/javascript">
    $(document).ready(function() {

        //Trigger nhấn nút xóa
        $(".delete-news").click(function() {

            var id = $(this).data("id"); //Lấy id

            var url = '{{ route("news.delete", ":id") }}';
            url = url.replace(':id', id); //replace ':id' thành id admin
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
    });
</script>
@endsection