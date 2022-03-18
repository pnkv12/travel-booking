@extends('layout.master')
@section('content')
<section style="height: 35em;">
    <h2 class="mb-3" style="padding-top: 15px;">Tour Packages <a href="{{ route('tours.add') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></a></h2>
    <hr class="my-3">
    <div>
        <form method="GET" action="" class="form-group">
            <div class="form-row">
                <div class="input-group rounded">
                    <div class="row" style="width:95%">
                        <div class="col">
                            <input type="text" name="query" class="form-control rounded" placeholder="Keywords..." aria-describedby="search-addon" />
                        </div>
                        <div class="col d-inline-flex">
                            <label for="departure" class="align-self-end">From:&nbsp;</label>
                            <input type="date" name="departure" class="form-control rounded" aria-describedby="search-addon" value="{{isset($_GET['departure'])? $_GET['departure'] : ' '}}" />
                        </div>
                        <div class="col d-inline-flex">
                            <label for="return" class="align-self-end">To:&nbsp;</label>
                            <input type="date" name="return" class="form-control rounded" aria-describedby="search-addon" value="{{isset($_GET['return'])? $_GET['return'] : ' '}}" />
                        </div>
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="btn btn-link text-info"><i class="fas fa-search"></i></button>
                        <button type="button" class="btn btn-link text-secondary" onclick="window.location.href='{{ route("tours.list") }}'"><i class="fas fa-undo-alt"></i></button>
                    </div>
                </div>
            </div>
    </div>
    </form>
    </div>
    <div class="table-content" style="padding-top: 9px;">
        <table class="table table-hover">
            <thead class="bg-info text-light">
                <!-- <th scope="col">ID</th> -->
                <th scope="col">Code</th>
                <th scope="col">Package Name</th>
                <th scope="col">Departure Date</th>
                <th scope="col">Return Date</th>
                <th scope="col">Price ($)</th>
                <th scope="col">Status</th>
                <th scope="col"> </th>
            </thead>
            <tbody>
                @if(!empty($data))
                @foreach($data as $item)
                <tr>
                    <td scope="row" hidden>{{$item['id']}}</td>
                    <td scope="row" onclick="window.location='{{ route("tours.details", $item['id']) }}'" style="cursor: pointer">{{$item['tour_code']}}</td>
                    <td scope="row" onclick="window.location='{{ route("tours.details", $item['id']) }}'" style="cursor: pointer">{{$item['name']}}</td>
                    <td scope="row" onclick="window.location='{{ route("tours.details", $item['id']) }}'" style="cursor: pointer">{{$item['departure']}}</td>
                    <td scope="row" onclick="window.location='{{ route("tours.details", $item['id']) }}'" style="cursor: pointer">{{$item['return']}}</td>
                    <td scope="row" onclick="window.location='{{ route("tours.details", $item['id']) }}'" style="cursor: pointer">{{$item['price']}}</td>
                    @if($item['is_active'] == 0)
                    <td scope="row" style="cursor: default;"><span class="badge bg-success text-light">Available</span></td>
                    @else
                    <td scope="row" style="cursor: default;"><span class="badge bg-warning text-light">Sold Out</span></td>
                    @endif

                    <td scope="row">
                        <div class="dropdown">
                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="cursor: pointer;">
                                <a class="dropdown-item" onclick="window.location=' {{ route("tours.edit", $item['id']) }} '" class="btn btn-info"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item text-danger" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td scope="row">Empty data</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <span class="d-flex flex-row-reverse">{{ $data->links() }}</span>

    <!-- Confirm delete tour with modal -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-primary delete-tour" data-id="{{ $item['id'] }}">Confirm</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('after_script')
<script type="text/javascript">
    $(document).ready(function() {

        //Trigger nhấn nút xóa
        $(".delete-tour").click(function() {

            var id = $(this).data("id"); //Lấy id

            var url = '{{ route("tours.delete", ":id") }}';
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