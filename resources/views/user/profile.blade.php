@extends('layout.master')
@section('content')
<section style="height: 470px">
    <div class="d-flex">
        <div class="p-2 align-self-center">
            <h2 class="mb-3" style="padding-top: 15px;">Personal Information</h2>
        </div>
        <div class="p-2 align-self-center">
            <a href="{{route('admin.edit', $data['id'])}}">Edit</a>
        </div>
    </div>
    <hr class="my-3">
    <div class="form-group d-flex justify-content-center">
        <div class="row" style="width: 90%">
            <div class="col">
                <div class="row">
                    <h3 class="text-uppercase">Account Info</h3>
                </div>
                <div class="row">
                    <label class="font-weight-bold">Account ID: &nbsp;</label>
                    <p> {{ $data['id'] }}</p>
                </div>
                <div class="row">
                    <label class="font-weight-bold">Fullname: &nbsp;</label>
                    <p class="text-uppercase"> {{ $data['fullname'] }}</p>
                </div>
                <div class="row">
                    <label class="font-weight-bold">Username: &nbsp;</label>
                    <p> {{ $data['username'] }}</p>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <h3 class=" text-uppercase">Contact</h3>
                </div>

                <div class="row">
                    <label class="font-weight-bold">Email: &nbsp;</label>
                    <p> {{ $data['email'] }}</p>
                </div>
                <div class="row">
                    <label class="font-weight-bold">Phone: &nbsp;</label>
                    <p> {{ $data['phone'] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection