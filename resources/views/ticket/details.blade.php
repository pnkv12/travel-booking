@extends('layout.master')
@section('content')
<section>
    <div class="d-flex bd-highlight mb-3">
        <div class="p-2 bd-highlight align-self-center">
            <h2 class="mb-3" style="padding-top: 15px;">Ticket: #{{$data['ticket_id']}}</h2>
        </div>
        <div class="p-2 bd-highlight align-self-center">
            <form id="update-ticket-state">
                @csrf
                <input name="ticket_id" value="{{ $data['ticket_id'] }}" hidden>
                <div class="m-1">
                    <div class="input-group-prepend">
                        <select class="custom-select mr-1" id="inputGroupSelect03" name="state">
                            <option value="0" <?php if ($data['state'] == 0) echo 'selected';
                                                else echo ''; ?>>New</option>
                            <option value="1" <?php if ($data['state'] == 1) echo 'selected';
                                                else echo ''; ?>>In Progress</option>
                            <option value="2" <?php if ($data['state'] == 2) echo 'selected';
                                                else echo ''; ?>>Done</option>
                        </select>
                        <button type="button" id="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="ml-auto p-2 bd-highlight align-self-center">
            <a href="{{route('ticket.list')}}">
                << Return to list</a>
        </div>
    </div>

    <hr class="my-3">
    <div class="form-group ml-4">
        <div class="col">
            <div class="row">
                <label class="font-weight-bold">Customer: &nbsp;</label>
                <p class="text-uppercase"> {{ $data['firstname'] }} {{ $data['lastname'] }}</p>
            </div>
            <div class="row">
                <label class="font-weight-bold">Phone: &nbsp;</label>
                <p> {{ $data['phone'] }}</p>
            </div>
            <div class="row">
                <label class="font-weight-bold">Tour Code: &nbsp;</label>
                @if (!empty($data['tour_code']))
                <p class="h5 font-weight-bold" style="cursor:pointer; color: blue" onclick="window.location='{{ route("tours.details", $data['tour_id']) }}'">{{ $data['tour_code'] }}</p>
                <span><small><em style="color: grey">(Click for more info on the tour)</em></small></span>
                @else
                <p class="text-danger">Tour is deleted</p>
                @endif

            </div>
            <div class="row">
                <label class="font-weight-bold">Email: &nbsp;</label>
                <p> {{ $data['email'] }}</p>
            </div>
            <div class="row">
                <label class="font-weight-bold">Address: &nbsp;</label>
                <p> {{ $data['address'] }}</p>
            </div>
            <div class="row pb-5">
                <label class="font-weight-bold">Notes: &nbsp;</label>
                @if (!empty($data['notes']))
                <p> {!! nl2br(e($data['notes']))!!}</p>
                @else
                <p style="color:gray"><em>No content</em></p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@section('after_script')
<script type="text/javascript">
    //trigger button update
    $('#submit').click(function() {
        //trigger form data
        var form = $('#update-ticket-state');

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
                url: '{{ route("ticket.update") }}',
                type: 'POST',
                data: form.serialize(),
                success: function(res) {
                    if (res.error === false) {
                        swal.fire(res.message, '', "success").then(function() {
                            window.location.href = "{{ route('ticket.list')}}";
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