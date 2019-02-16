@extends('layouts.app')
@section('content')
    <div class="d-flex align-items-baseline mb-2">
        <h3 class="font-weight-bold flex-grow-1">Products</h3>
        <a href="/products/create" class="btn btn-outline-primary">Add</a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>BRAND</th>
                        <th>CATEGORY</th>
                        <th>PRICE</th>
                        <th>QUANTITY</th>
                        <th>LAST UPDATE</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    {{--{{$product->id}}--}}
                                    <img class="img-fluid" width="32" src="{{asset('images/'.$product->image)}}" alt="">
                                </td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->brand->name}}</td>
                                <td>{{$product->category->name}}</td>
                                <td>{{$product->price}}</td>
                                <td>{{$product->quantity}}</td>
                                <td>{{$product->updated_at->toDayDateTimeString()}}</td>
                                <td>
                                    <div class="btn-group-sm">
                                        <button class="btn btn-outline-primary">Edit</button>
                                        <button class="btn btn-primary" onclick="delete_product({{$product->id}})">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function delete_product(id) {
            if (confirm('Are you sure?')) {
                axios.post('/products/' + id)
                // .then(window.location.reload())
            }
        }
    </script>
@endsection