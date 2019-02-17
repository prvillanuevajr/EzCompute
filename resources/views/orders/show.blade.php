@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card border-dark">
                <div class="card-header d-flex">
                    <h5 class="flex-grow-1">
                        @if($order->delivery_date && $order->status != 'invoiced')
                            Delivery Date:
                            {{$order->delivery_date->toFormattedDateString()}}
                        @else
                            Status: <span class="badge @if($order->status == 'invoiced') badge-success @else badge-warning @endif">{{$order->status}}</span>
                        @endif
                    </h5>
                    @if($order->status == 'pending')
                        <form action="/orders/{{$order->id}}/cancel" method="post">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm float-right">Cancel order</button>
                        </form>
                    @endif
                </div>
                <div class="card-body">
                    @admin
                    @if(!$order->delivery_date)
                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <form action="/orders/{{$order->id}}/update" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="delivery_date">Set Delivery Date</label>
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <input required id="delivery_date" name="delivery_date" type="date"
                                                   class="form-control mr-4">
                                            <button class="btn btn-success btn-sm float-right">Confirm</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                    @endif
                    @endadmin
                    <table class="table table-borderless">
                        <thead>
                        <th></th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                        </thead>
                        <tbody>
                        @foreach($order->details as $detail)
                            <tr>
                                <td><img src="/images/{{$detail->product->image}}" class="img-fluid" width="32" alt="">
                                </td>
                                <td>{{$detail->product->name}}</td>
                                <td>{{$detail->product->brand->name}}</td>
                                <td>{{$detail->quantity}}</td>
                                <td>₱{{$detail->price}}</td>
                                <td>₱{{$detail->price * $detail->quantity}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4"></td>
                            <td><h4 class="font-weight-bold">Total:</h4></td>
                            <td><h4 class="font-weight-bold">₱{{$order->total_price}}</h4></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection