@extends('layouts.app')
@section('content')
    <h3 class="font-weight-bold">Categories</h3>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Parent</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{$category->id}}</td>
                                <td>{{$category->name}}</td>
                                <td>{!!$category->parent ? $category->parent->name: '<b>PARENT</b>'!!}</td>
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
                    <h3>Create Category</h3>
                </div>
                <div class="card-body">
                    <form action="/categories" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="cat">Parent Category</label>
                            <select class="form-control" name="category_id" id="cat">
                                <option value="0">Parent Category</option>
                                @foreach($categories->where('category_id',null) as $category)
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
                axios.post(`/categories/${id}`)
                    .then(window.location.reload(true))
            }
        }
    </script>
@endsection