@extends('layout.master')
@section('content')
<section>
    <div class="d-flex bd-highlight mb-3">
        <div class="p-2 bd-highlight align-self-center">
            <h2 class="mb-3" style="padding-top: 15px;">Details ID: {{ $data['id']}}</h2>
        </div>
        <div class="p-2 align-self-center bd-highlight">
            @if($data['is_active'] == 0)
            <span class="badge badge-success" name="is_active">Available</span>
            @else
            <span class="badge badge-warning text-light" name="is_active">Sold Out</span>
            @endif
        </div>
        <div class="ml-auto p-2 bd-highlight align-self-center">
            <a href="{{route('tours.list')}}">
                << Return to list</a>
        </div>
    </div>

    <hr class="my-3">

    <div class="d-flex justify-content-center">
        <div class="row" style="width:80%">
            <div class="col">
                <div class="row">
                    @if ($data['photo_id']== 0)
                    <p>No photo available</p>
                    @else
                    <img src="{{asset('storage/image/'.$data['photo_name'])}}" width="80%" />
                    @endif
                </div>
                <div class="row">
                    <label class="font-weight-bold">Code: &nbsp;</label>
                    <p class="text-uppercase"> {{ $data['tour_code'] }}</p>
                </div>
                <div class="row">
                    <label class="font-weight-bold">Package Name: &nbsp;</label>
                    <p class="text-uppercase"> {{ $data['name'] }}</p>
                </div>
                <div class="row">
                    <label class="font-weight-bold">Departure Date: &nbsp;</label>
                    <p> {{ $data['departure'] }}</p>
                </div>
                <div class="row">
                    <label class="font-weight-bold">Return Date: &nbsp;</label>
                    <p> {{ $data['return'] }}</p>
                </div>
                <div class="row">
                    <label class="font-weight-bold">Price: &nbsp;</label>
                    <p class="text-info font-weight-bold "><big>${{ $data['price'] }}</big></p>
                </div>
                <div class="row">
                    <label class="font-weight-bold">Remaing slots: &nbsp;</label>
                    @if ($data['slots'] <= 5) <p class="text-danger">{{ $data['slots'] }}</p>
                        @else
                        <p class="text-info">{{ $data['slots'] }}</p>

                        @endif

                </div>
                <div class="row">
                    <label class="font-weight-bold">Travel By: &nbsp;</label>
                    <p>
                        <?php
                        if ($data['vehicle' == 0]) {
                            echo "Plane";
                        } elseif ($data['vehicle' == 1]) {
                            echo "Bus";
                        } else {
                            echo "Ship";
                        }
                        ?>
                    </p>
                </div>
            </div>
            <div class="col">
                <label class="font-weight-bold">Details: &nbsp;</label>
                <p class="text-justify pb-5"> {!! nl2br(e($data['details']))!!}</p>
            </div>
        </div>

    </div>
</section>
@endsection