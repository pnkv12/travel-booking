@extends('layout.master')
@section('content')
<section style="height: 35em">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="mb-3" style="padding-top: 15px;">Booking Tickets</h2>
        </div>
        <div class="d-flex align-self-end">
            <form method="GET" action="" class="form-group">
                <div class="form-row">
                    <div class="input-group rounded">

                        <!-- Search by name, code, phone -->
                        <input type="text" name="query" class="form-control rounded" placeholder="Search" aria-describedby="search-addon" style="width:40%; margin-right: 1rem;" />

                        <!-- Search by Ticket's state -->
                        <select name="state" class="form-control rounded" style="margin-right: 1rem;">
                            <option value="" hidden>State</option>
                            <option <?php if (isset($_GET['state']) && $_GET['state'] == '0') {
                                        echo 'selected';
                                    } ?> value="0">New</option>
                            <option <?php if (isset($_GET['state']) && $_GET['state'] == '1') {
                                        echo 'selected';
                                    } ?> value="1">In Progress</option>
                            <option <?php if (isset($_GET['state']) && $_GET['state'] == '2') {
                                        echo 'selected';
                                    } ?> value="2">Done</option>
                        </select>

                        <span id="search-addon">
                            <button type="submit" class="btn btn-link text-info"><i class="fas fa-search"></i></button>
                        </span>
                        <button type="button" class="btn btn-link text-secondary" onclick="window.location.href='{{ route("ticket.list") }}'"><i class="fas fa-undo-alt"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr class="my-3">
    <div class="table-content" style="padding-top: 9px;">
        <table class="table table-hover">
            <thead class="bg-info text-light">
                <th scope="col">#Ticket</th>
                <th scope="col">Client</th>
                <th scope="col">Tour Code</th>
                <th scope="col">Phone</th>
                <th scope="col">State</th>
                <th scope="col">Created At</th>
            </thead>
            <tbody>
                @if(count($data) > 0)
                @foreach($data as $item)
                <tr>
                    <td scope="row" style="cursor: pointer" onclick="window.location='{{ route("ticket.details", $item['ticket_id']) }}'">{{$item['ticket_id']}}</td>
                    <td scope="row" class="font-weight-bold" style="cursor: pointer" onclick="window.location='{{ route("ticket.details", $item['ticket_id']) }}'">{{$item['firstname']}} {{$item['lastname']}}</td>

                    @if(!empty($item['tour_code']))
                    <td scope="row" class="font-weight-bold text-primary" style="cursor: pointer" onclick="window.location='{{ route("ticket.details", $item['ticket_id']) }}'">{{$item['tour_code']}}</td>
                    @else
                    <td>No data</td>
                    @endif

                    <td scope="row" style="cursor: pointer" onclick="window.location='{{ route("ticket.details", $item['ticket_id']) }}'">{{$item['phone']}}</td>

                    @if($item['state'] == 0)
                    <td scope="row"><span class="badge badge-success">New</span></td>
                    @elseif($item['state'] == 1)
                    <td scope="row"><span class="badge badge-warning text-light">In Progress</span></td>
                    @else($item['state'] == 2)
                    <td scope="row"><span class="badge badge-info text-light">Done</span></td>
                    @endif

                    <td scope="row">{{$item['created_at']}}</td>
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
    <span class="d-flex flex-row-reverse">{{ $data->links() }}</span>
</section>
@endsection