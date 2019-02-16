@extends('layouts.app')
@section('content')

    <h3 class="font-weight-bold">Brands</h3>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <th>ID</th>
                        <th>Brand Name</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($brands as $brand)
                            <tr>
                                <td>{{$brand->id}}</td>
                                <td>{{$brand->name}}</td>
                                <td>{{$brand->created_at}}</td>
                                <td>{{$brand->updated_at}}</td>
                                <td>
                                    <button class="btn-sm btn-primary btn">Edit</button>
                                    <button class="btn-sm btn-primary btn delbtn"
                                            onclick="delete_category({{$brand->id}})">
                                        Del
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Create</h3>
                </div>
                <div class="card-body">
                    <form action="/brands" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <button class="btn btn-outline-primary float-right">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function delete_category(id) {
            if (confirm('Are you sure?')) {
                axios.post(`/brands/${id}`)
                    .then(window.location.reload(true))
            }
        }

    </script>
@endsection