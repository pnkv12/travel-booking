@extends('layout.master')
@section('content')
<section>
    <h2 class="mb-3" style="padding-top: 15px;">Contacts</h2>
    <hr class="my-3">
    <div class="table-content" style="padding-top: 9px;">
        <table class="table table-striped">
            <thead class="bg-info text-light">
                <th>ID</th>
                <th scope="col">Fullname</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Status</th>
            </thead>
            <tbody>
                @if(!empty($data))
                @foreach($data as $item)
                <tr>
                    <td scope="row">{{$item['id']}}</td>
                    <td scope="row">{{$item['fullname']}}</td>
                    <td scope="row">{{$item['email']}}</td>
                    <td scope="row">{{$item['phone']}}</td>
                    @if($item['is_new'] == 0)
                    <td scope="row" style="cursor: default;"><span class="badge bg-primary text-light">New</span></td>
                    @else
                    <td scope="row" style="cursor: default;"><span class="badge bg-success text-light">Current</span></td>
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
</section>
@endsection