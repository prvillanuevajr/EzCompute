@extends('layouts.app')
@section('content')
    <div class="col-lg-6 offset-lg-3">
        <div class="card">
            <div class="card-header">
                <h3>Create Category</h3>
            </div>
            <div class="card-body">
                <form action="/categories" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection