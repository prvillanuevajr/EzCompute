@extends('layouts.app')
@section('content')

    <h3 class="font-weight-bold">Sub Categories</h3>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Parent Category</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($sub_categories as $category)
                            <tr>
                                <td>{{$category->id}}</td>
                                <td>{{$category->name}}</td>
                                <td>{{$category->category->name}}</td>
                                <td>{{$category->created_at}}</td>
                                <td>{{$category->updated_at}}</td>
                                <td>
                                    <button class="btn-sm btn-primary btn">Edit</button>
                                    <button class="btn-sm btn-primary btn delbtn"
                                            onclick="delete_category({{$category->id}})">
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
                    <form action="/sub_categories" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="cat">Parent Category</label>
                            <select class="form-control" name="category_id" id="cat">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
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
                axios.delete(`/sub_categories/${id}`)
                    .then(window.location.reload(true))
            }
        }
    </script>
@endsection