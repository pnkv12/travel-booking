@extends('layout.master')
@section('content')
<section style="height: 470px;">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="mb-3" style="padding-top: 15px;">Contacts</h2>
        </div>
        <div class="d-flex align-self-end">
            <form method="GET" action="" class="form-group">
                <div class="form-row">
                    <div class="input-group rounded">
                        <input type="text" name="query" class="form-control rounded" placeholder="Search" aria-describedby="search-addon"/>
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
    <div class="table-content" style="padding-top: 9px;">
        <table class="table table-striped">
            <thead class="bg-info text-light text-center">
                <th>Admin</th>
                <th scope="col">Fullname</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
            </thead>
            <tbody>
                @if(!empty($data))
                @foreach($data as $item)
                <tr>
                    <td scope="row" class="text-center">{{$item['id']}}</td>
                    <td scope="row">{{$item['fullname']}}</td>
                    <td scope="row">{{$item['username']}}</td>
                    <td scope="row"> <a href="#">{{$item['email']}}</a></td>
                    <td scope="row">{{$item['phone']}}</td>
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
</section>
@endsection