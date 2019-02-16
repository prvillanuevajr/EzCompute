@extends('layouts.app')
@section('content')
    <h3 class="font-weight-bold">Add product</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="/products" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label for="">Name</label>
                                <input  type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="price">Price</label>
                                <input  type="number" class="form-control" name="price" id="price">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="brand_id">Brand</label>
                                <select  class="form-control" name="brand_id" id="brand_id">
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="category_id">Brand</label>
                                <select  class="form-control" name="category_id" id="category_id">
                                    @foreach($categories->where('category_id','!=',null) as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="image" class="btn btn-primary">Choose Photo</label>
                                <br>
                                <input style="display: none;" id="image" type="file" name="image" accept="image/*">
                                <img width="128" height="128" class="img-fluid" id="image_preview" src="{{asset('images/Logo.png')}}" alt="">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="">Description</label>
                                <textarea rows="10"  class="form-control" name="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet aut facere fugit hic magni, officiis! A alias assumenda atque blanditiis deserunt, doloribus ea eos est, eveniet excepturi id in inventore iste labore minima mollitia nam necessitatibus nesciunt nisi officiis omnis, perferendis perspiciatis porro provident quas quasi qui reiciendis sapiente temporibus.</textarea>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="">Quantity</label>
                                <input  type="number" class="form-control" name="quantity" value="0">
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary float-right">Save</button>
                                <a href="/products" class="btn btn-outline-dark float-right mr-2">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function () {
            $("#image").change(function () {
                readURL(this);
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection