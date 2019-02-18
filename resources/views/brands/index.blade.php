@extends('layouts.app')
@section('content')

    <h3 class="font-weight-bold">Brands</h3>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <table class="table datatable table-hover table-bordered">
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
                                <td class="td_editable" ondblclick="edit('{{$brand->name}}','{{$brand->id}}')">{{$brand->name}}</td>
                                <td>{{$brand->created_at}}</td>
                                <td>{{$brand->updated_at}}</td>
                                <td>
                                    <button class="btn-sm btn-primary btn delbtn"
                                            onclick="delete_brand({{$brand->id}},'{{$brand->name}}')">
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
        function delete_brand(id,name) {
            Swal.fire({
                title: `Delete ${name}?`,
                text:`Are you sure?`,
                type: "question",
                showCancelButton: true,
                focusCancel: true,
                preConfirm: () => {
                    axios.post(`/brands/${id}`)
                        .then(window.location.reload(true))
                }
            })
        }

        function edit(previous_val, id) {
            Swal.fire({
                title: `Update Brand's name.`,
                html:
                `<p>Previous name: ${previous_val}</p>` +
                '<input id="col" name="col" type="text" class="swal2-input">',
                focusConfirm: false,
                showCancelButton: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    let val = $('#col').val().trim();
                    if (val) {
                        axios.post(`/brands/${id}/update`,{value: val})
                            .then(e => window.location.reload(true))
                            .catch(e => setTimeout(() => Swal.fire('Something Went Wrong!')),500)
                        return false
                    }
                    setTimeout(() => {
                        Swal.fire('Invalid Name','Name provided is invalid','warning');
                    },500)
                }
            })
        }

    </script>
@endsection