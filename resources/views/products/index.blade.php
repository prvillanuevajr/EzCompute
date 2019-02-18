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
                    <table class="table table-hover datatable table-bordered">
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
                            <tr data-content="{{$product->id}}">
                                <td>
                                    {{--{{$product->id}}--}}
                                    <img class="img-fluid" width="32" src="{{asset('images/'.$product->image)}}" alt="">
                                </td>
                                <td class="td_editable" ondblclick="edit('name','{{$product->id}}','{{$product->name}}')">{{$product->name}}</td>
                                <td>{{$product->brand->name}}</td>
                                <td>{{$product->category->name}}</td>
                                <td class="td_editable" ondblclick="edit('price','{{$product->id}}','{{string_to_currency($product->price)}}')">{{string_to_currency($product->price)}}</td>
                                <td class="td_editable" ondblclick="edit('quantity','{{$product->id}}','{{$product->quantity}}')">{{$product->quantity}}</td>
                                <td>{{$product->updated_at->toDayDateTimeString()}}</td>
                                <td>
                                    <div class="btn-group-sm">
                                        <button class="btn btn-primary" onclick="delete_product('{{$product->id}}','{{$product->name}}')">
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
        function delete_product(id,name) {
            Swal.fire({
                title: `Delete ${name}?`,
                text:`Are you sure?`,
                type: "question",
                showCancelButton: true,
                focusCancel: true,
                preConfirm: () => {
                    axios.post('/products/' + id)
                        .then(window.location.reload())
                }
            })
        }

        function edit(col, product_id, previous_val) {
            Swal.fire({
                title: `Update Product's ${col}`,
                html:
                `<p>Previous ${col}: ${previous_val}</p>` +
                '<input id="col" name="col" type="text" class="swal2-input">',
                focusConfirm: false,
                showCancelButton: true,
                showLoaderOnConfirm: true,
                preConfirm: (pres) => {
                    let val = $('#col').val().trim();
                    if (val) {
                        if (['price', 'quantity'].includes(col)) {
                            if (!isNaN(val) && parseInt(val) >= 0) {
                                axios.post(`/products/${product_id}/update`, {column: col, value: val})
                                    .then(({data}) => {
                                        window.location.reload(true)
                                    })
                                    .catch(({response}) => console.log(response))
                            }else{
                                Swal.close();
                                setTimeout(function () {
                                    Swal.fire(`Invalid input`,`Invalid input for ${col}.`,'warning')
                                },300)
                            }
                        } else {
                            axios.post(`/products/${product_id}/update`, {column: col, value: val})
                                .then(({data}) => console.log(data))
                                .catch(({response}) => console.log(response))
                        }
                    }
                }
            })
        }

    </script>
@endsection