@extends('layouts.app')
@section('content')
    @if(!app('request')->input('search') && !app('request')->input('category'))
        <div class="row mb-3">
            <div class="col-lg-8 offset-lg-2">
                <div id="demo" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        @foreach($recently_added_products as $key => $product)
                            <div class="carousel-item @if(!$key) active @endif">
                                <h3 class="font-weight-bold">New Arival</h3>
                                <div class="d-md-flex">
                                    <img width="256" height="256" class="img-thumbnail" src="{{asset('images/'.$product->image)}}" alt="Los Angeles">
                                    <div class="d-flex flex-column">
                                        <p class="p-4">
                                            <strong>{{$product->name}}</strong>
                                            <br>
                                            {{$product->description}}
                                            <br>
                                        </p>
                                        <a href="shop/product?name={{$product->name}}&id={{$product->id}}"
                                           class="btn btn-outline-primary px-2">DETAILS</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#demo" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#demo" data-slide="next">
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