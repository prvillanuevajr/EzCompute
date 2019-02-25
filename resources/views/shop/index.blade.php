@extends('layouts.app')
@section('content')
    @if(!app('request')->input('search') && !app('request')->input('category'))
        <div class="row mb-3 shop-carousel-div d-flex">
            <div class="col-lg-12">
                <div id="shop-carousel-1" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        @foreach($recently_added_products as $key => $product)
                            <a href="shop/product?name={{$product->name}}&id={{$product->id}}" class="carousel-item @if(!$key) active @endif">
                                <h3 class="font-weight-bold">New Arival</h3>
                                <div class="d-md-flex text-sm-only-center">
                                    <img width="256" height="256" class="img-thumbnail shop-carousel-img" src="{{asset('images/'.$product->image)}}" alt="Los Angeles">
                                    <div class="d-flex flex-column p-4 align-items-center">
                                        <h3 class="shop-carousel-item-name">{{$product->name}}</h3>
                                        <p>{{$product->description}}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#shop-carousel-1" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#shop-carousel-1" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
            </div>
        </div>
        <hr>
    @endif
    <catalouge class="catalouge" :rbrands="{{$brands}}"></catalouge>
@endsection
@section('scripts')
@endsection