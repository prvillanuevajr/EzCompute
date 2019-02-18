@extends('layouts.app')
@section('content')
    <h3 class="font-weight-bold">Product Detail</h3>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body text-center">
                    <img width="256" height="256" class="img-fluid img-thumbnail mb-4" src="{{asset('images/'.$product->image)}}" alt="">
                    <div class="text-left">
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
                            @if($product->quantity)
                                <form action="/cart" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <button class="btn btn-primary">ADD TO CART <i class="fa fa-plus"></i></button>
                                </form>
                            @else
                                <button class="btn btn-danger">Out of stock</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <ratings :product="{{$product}}" :prop_ratings="{{$ratings}}"></ratings>
        </div>
    </div>
@endsection
@section('scripts')
@endsection