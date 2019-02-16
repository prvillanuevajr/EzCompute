@extends('layouts.app')
@section('content')
    <h3 class="font-weight-bold">Product Detail</h3>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <img class="img-fluid" src="{{asset('images/'.$product->image)}}" alt="">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bold">{{$product->name}}</h4>
                    <hr>
                    <p><strong>Category: {{$product->category->name}}</strong></p>
                    <p><strong>BRAND: {{$product->brand->name}}</strong></p>
                    <p><strong>PRICE: ₱{{number_format($product->price)}}</strong></p>
                    <p>
                        <strong>QUICK DESCRIPTION:</strong>
                        <br>
                        {{$product->description}}
                    </p>
                    <div class="d-flex">
                        <button onclick="window.history.back();" class="btn btn-outline-primary mr-4">BACK</button>
                        <form action="/cart" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <button class="btn btn-primary">ADD TO CART <i class="fa fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection