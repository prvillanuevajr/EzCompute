@extends('layouts.app')
@section('content')
    <div class="container">
        <h3 class="font-weight-bold">Orders</h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table order_datatable table-borderless">
                                <thead>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date ordered</th>
                                <th>Delivery date</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{$order->user->email}}</td>
                                        <td>{{string_to_currency($order->total_price)}}</td>
                                        <td>
                                            <span class="badge @if($order->status == 'invoiced') badge-success @else badge-warning @endif">{{$order->status}}</span>
                                        </td>
                                        <td>{{$order->created_at->toFormattedDateString()}}</td>
                                        <td>{{$order->delivery_date ? $order->delivery_date->toFormattedDateString() :''}}</td>
                                        <td class="d-flex justify-content-around">
                                            <a href="/orders/{{$order->id}}" class="btn-sm btn-primary btn">view</a>
                                            @if($order->status == 'pending')
                                                <form action="/orders/{{$order->id}}/cancel" method="post">
                                                    @csrf
                                                    <button class="btn btn-dark btn-sm">cancel</button>
                                                </form>
                                            @else
                                                <a href="/invoices/{{$order->invoice->id}}" class="btn-sm btn-primary btn">receipt</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('.order_datatable').DataTable({
            "order": [[ 2, "desc" ]],
        });
    </script>
@endsection