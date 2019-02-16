@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <cart :ritems="{{auth()->user()->carts()->with('product.brand')->get()}}"></cart>
        </div>
    </div>
@endsection
@section('scripts')
@endsection