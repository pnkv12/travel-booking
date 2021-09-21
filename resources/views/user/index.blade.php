@extends('layout.master')
@section('content')
<section>
    <!--Jumbotron quick link-->
    <div class="jumbotron jumbotron-fluid text-center" style="background-image: url('{{asset("assets/image/light-teal-bg.jpg")}}');">
        <h1 class="mb-3">You have arrived at Admin Dashboard</h1>
        <h4 class="mb-3">Start adding something...</h4>
    </div>
    <hr class="my-3">
    <!--Content-->
    <div style="padding-top: 15px">
        <!--Search & Tours-->
        <div class="row">
            <div class="col-sm-6" style="padding-bottom: 20px">
                <div class="card text-center">
                    <div class="card-body bg-light">
                        <a href="#" class="text-dark">
                            <h5 class="card-title font-weight-bold"><i class="fas fa-search"></i> Search</h5>
                        </a>
                        <p class="card-text">Go to search panel</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card text-center">
                    <div class="card-body bg-light">
                        <a href="#" class="text-dark">
                            <h5 class="card-title font-weight-bold"><i class="fab fa-font-awesome-flag"></i> Tours</h5>
                        </a>                       
                        <p class="card-text">Create new tour packages</p>
                    </div>
                </div>
            </div>
        </div>
        <!--Contacts & News-->
        <div class="row" style="padding-bottom: 20px">
            <div class="col-sm-6" style="padding-bottom: 20px">
                <div class="card text-center">
                    <div class="card-body bg-light">
                        <a href="{{ route('admin.list') }}" class="text-dark">
                            <h5 class="card-title font-weight-bold"><i class="fas fa-user"></i> Contacts</h5>
                        </a>
                        <p class="card-text">See other users' contact details</p>

                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card text-center">
                    <div class="card-body bg-light">
                        <a href="{{ route('news.add') }}" class="text-dark">
                            <h5 class="card-title font-weight-bold"><i class="fas fa-newspaper"></i> News</h5>
                        </a>
                        <p class="card-text">Create new content for tourism</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection