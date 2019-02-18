@extends('layouts.app')
@section('content')
    <h3 class="font-weight-bold">Categories</h3>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover datatable table-bordered">
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
                                <td class="td_editable"
                                    ondblclick="edit('{{$category->name}}','{{$category->id}}')">{{$category->name}}</td>
                                <td>{!!$category->parent ? $category->parent->name: '<b>PARENT</b>'!!}</td>
                                <td>{{$category->created_at}}</td>
                                <td>{{$category->updated_at}}</td>
                                <td>
                                    <button class="btn-sm btn-primary btn delbtn"
                                            onclick="delete_category({{$category->id}},'{{$category->name}}')">
                                        Delete
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
        function delete_category(id,name) {
            Swal.fire({
                title: `Delete ${name}?`,
                text:`Are you sure?`,
                type: "question",
                showCancelButton: true,
                focusCancel: true,
                preConfirm: () => {
                    axios.post(`/categories/${id}`)
                        .then(window.location.reload(true))
                }
            })
        }

        function edit(previous_val, id) {
            Swal.fire({
                title: `Update Category's name.`,
                html:
                `<p>Previous name: ${previous_val}</p>` +
                '<input id="col" name="col" type="text" class="swal2-input">',
                focusConfirm: false,
                showCancelButton: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    let val = $('#col').val().trim();
                    if (val) {
                        axios.post(`/categories/${id}/update`, {value: val})
                            .then(e => window.location.reload(true))
                            .catch(e => setTimeout(() => Swal.fire('Something Went Wrong!')), 500)
                        return false
                    }
                    setTimeout(() => {
                        Swal.fire('Invalid Name', 'Name provided is invalid', 'warning');
                    }, 500)
                }
            })
        }
    </script>
@endsection