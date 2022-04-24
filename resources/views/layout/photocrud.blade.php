<?php
$role = auth()->user()->role;
?>
@extends($role ==="Admin" ? 'layout.master' : 'layout.collab-layout')
@section('content')

<div class="d-flex justify-content-between">
    <div>
        <h2 class="mb-3" style="padding-top: 15px;"> Photo Bucket</h2>
    </div>
    <div class="d-flex align-self-end">
        <form method="POST" action="{{route('deliver.upload')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-row ">
                <div class="input-group rounded">
                    <input type="file" class="form-control" name="photo" multiple>
                    <button type="submit" class="btn btn-primary" style="margin-left:1rem"><i class="fas fa-plus"></i></button>
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
            <th scope="col">Preview</th>
            <th scope="col">Name</th>
            <th scope="col"></th>
        </thead>
        <tbody>
            @if(!empty($image))
            @foreach($image as $photo)
            <tr>
                <td scope="row">{{$photo['photo_id']}}</td>
                <td scope="row" style="cursor: pointer" data-toggle="modal" data-target="#popup-photo_{{$photo['photo_id']}}"><img src="{{asset('storage/image/'.$photo->photo_name)}}" class="description" width="500px" /></td>
                <td scope="row" class="font-weight-bold">{{$photo['photo_name']}}</td>
                <td scope="row">
                    <a class="btn btn-link text-danger" data-toggle="modal" data-target="#confirm-delete_{{$photo['photo_id']}}" data-item-id="{{$photo['photo_id']}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
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
<span class="d-flex justify-content-center">{{ $image->links() }}</span>

<!-- Confirm delete photo with modal -->
@foreach($image as $photo)
<div class="modal fade" id="confirm-delete_{{$photo['photo_id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure {{$photo['photo_id']}}?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                This action cannot be undone
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger delete-photo" data-id="{{ $photo['photo_id'] }}">Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
    .photo-modal {
        position: absolute;
        float: left;
        left: 12%;
        transform: translate(-50%, -50%);
    }

    .detail-style {
        width: 100%;
    }
</style>

<!-- Pop up Photo -->
@foreach($image as $photo)
<div id="popup-photo_{{$photo['photo_id']}}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog photo-modal">
        <div class="modal-content">
            <img src="{{asset('storage/image/'.$photo->photo_name)}}" class="img-responsive" width="200%">
        </div>
    </div>
</div>
@endforeach
@endsection

@section('after_script')
<script type="text/javascript">
    $(document).ready(function() {

        //Trigger nhấn nút xóa
        $(".delete-photo").click(function() {

            var id = $(this).data("id"); //Lấy id

            var url = '{{ route("photo.delete", ":id") }}';
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
    });
</script>
@endsection