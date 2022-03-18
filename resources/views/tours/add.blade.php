@extends('layout.master')
@section('content')
<section class="content">
    <div class="d-flex bd-highlight mb-3" style="padding-top: 15px;">
        <div class="p-2 bd-highlight align-self-center">
            <h2 class="mb-3">New Tour Package</h2>
        </div>
        <div class="ml-auto p-2 bd-highlight align-self-center">
            <a href="{{route('tours.list')}}">
                << Return to list</a>
        </div>
    </div>
    <hr class="my-3">
    <div class="form-group">
        <form id="form-data">
            @csrf
            <div class="row">
                <!-- Package Name -->
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Package Name:<span class="error">*</span>
                        </div>
                        <input type="text" class="form-control" name="name" placeholder="Name here..." aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Departure -->
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Departure Date:<span class="error">*</span>
                        </div>
                        <input type="date" class="form-control" name="departure" aria-describedby="basic-addon1" min="2021-09-01">
                    </div>
                </div>
                <!-- Return -->
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Return Date:<span class="error">*</span>
                        </div>
                        <input type="date" class="form-control" name="return" aria-describedby="basic-addon1" min="2021-09-01">
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Price -->
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">$ <span class="error">*</span>
                        </div>
                        <input type="number" step=".01" class="form-control" name="price" aria-describedby="basic-addon1" placeholder="00.00">
                    </div>
                </div>
                <!-- Vehicle -->
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Travel By:<span class="error">*</span></label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01" name="vehicle">
                            <option value="" hidden>Select one...</option>
                            <option value="0">Plane</option>
                            <option value="1">Bus</option>
                            <option value="2">Ship</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Details -->
            <textarea type="text" name="details" class="form-control" placeholder="Package details here..." rows="10" style="resize:none"></textarea> <br>

            <!-- Button group -->
            <div class="form-group d-flex justify-content-center">
                <button type="button" id="submit-content" class="btn btn-primary btn-lg">Create</button>
                <button type="button" class="btn btn-link btn-lg" onclick="window.location='{{ route('tours.list') }}'">Cancel</button>
            </div>
        </form>
    </div>
</section>
@endsection
@section('after_script')
<script type="text/javascript">
    $(document).ready(function() {
        //trigger button add
        $('#submit-content').click(function() {
            //trigger form add
            var form = $('#form-data');
            //setup csrf
            $.ajaxSetup({
                headers: {
                    //get csrf form content of meta tag
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //validate form
            form.validate({
                rules: {
                    // tour_code: {
                    //     required: true,
                    // },
                    name: {
                        required: true,
                    },
                    departure: {
                        required: true,
                    },
                    return: {
                        required: true,
                    },
                    price: {
                        required: true,
                    },
                    vehicle: {
                        required: true,
                    },
                    details: {
                        minlength: 160,
                    },
                },
                messages: {
                    // tour_code: {
                    //     required: 'Tour Code is required',
                    // },
                    name: {
                        required: 'Package name is required',
                    },
                    departure: {
                        required: 'Departure date is required',
                    },
                    return: {
                        required: 'Return date is required',
                    },
                    price: {
                        required: 'Package price is required',
                    },
                    vehicle: {
                        required: 'Vehicle is required',
                    },
                    details: {
                        minlength: 'Must be at least 160 characters',
                    },
                }
            });
            //if form valid -> call ajax
            if (form.valid()) {
                //disable button add prevent dup click
                $('#submit-content').attr('disabled', true);
                $.ajax({
                    url: '{{ route("tours.store") }}',
                    type: 'POST',
                    data: form.serialize(),
                    success: function(res) {
                        if (res.error === false) {
                            swal.fire(res.message, '', "success").then(function() {
                                window.location.href = "{{ route('tours.list')}}";
                            });
                        } else {
                            swal.fire(res.message, '', "error").then(function() {
                                $('#submit-content').attr('disabled', false);
                            });
                        }
                    },
                    error: function(res) {
                        if (res.responseJSON != undefined) {
                            var mess_error = '';
                            $.map(res.responseJSON.errors, function(a) {
                                mess_error = mess_error.concat(a + '<br/>');
                            });
                            swal.fire('Fail to add new package!', mess_error, "error").then(function() {
                                $('#submit-content').attr('disabled', false);
                            });
                        }
                    }
                });
            }
        });
    })
</script>
@endsection