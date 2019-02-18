@extends('layouts.app')
@section('content')
    <div id="invoice">
        <div class="invoice overflow-auto">
            <div style="min-width: 600px">
                <header>
                    <div class="row">
                        <div class="col">
                            <a target="_blank" href="/">
                                <img src="/images/Logo.png" data-holder-rendered="true"/>
                                <h3 class="d-inline">{{env('APP_NAME', 'EzCompute')}}</h3>
                            </a>
                        </div>
                        <div class="col company-details">
                            <h2 class="name">
                                <a target="_blank" href="">
                                    {{env('APP_NAME', 'EzCompute')}}
                                </a>
                            </h2>
                            <div>455 Foggy Heights, AZ 85004, US</div>
                            <div>(123) 456-789</div>
                            <div>{{env('APP_NAME', 'EzCompute')}}@gmail.com</div>
                        </div>
                    </div>
                </header>
                <main>
                    <div class="row contacts">
                        <div class="col invoice-to">
                            <div class="text-gray-light">INVOICE TO:</div>
                            <h2 class="to">{{$invoice->user->name}}</h2>
                            <div class="address">{{$invoice->user->address}}</div>
                            <div class="email"><a href="mailto:{{$invoice->user->email}}">{{$invoice->user->email}}</a></div>
                        </div>
                        <div class="col invoice-details">
                            <h1 class="invoice-id">INVOICE {{$invoice->id}}</h1>
                            <div class="date">Date of Invoice: {{$invoice->created_at->toFormattedDateString()}}</div>
                        </div>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-left">NAME</th>
                            <th class="text-right">BRAND</th>
                            <th class="text-right">CATEGORY</th>
                            <th class="text-right">PRICE</th>
                            <th class="text-right">QUANTITY</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($details as $key => $detail)
                            <tr>
                                <td class="no">{{$key+1}}</td>
                                <td class="text-left"><h3>{{$detail->name}}</h3>
                                </td>
                                <td class="text-left unit">{{$detail->brand}}</td>
                                <td class="text-left">{{$detail->category}}</td>
                                <td class="unit">{{string_to_currency($detail->price)}}</td>
                                <td class="qty">{{$detail->quantity}}</td>
                                <td class="total">{{string_to_currency($detail->price * $detail->quantity)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="2">SUBTOTAL</td>
                            <td>{{string_to_currency($invoice->total_price)}}</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="2">GRAND TOTAL</td>
                            <td>{{string_to_currency($invoice->total_price)}}</td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="thanks">Thank you!</div>
                </main>
                <footer>
                    Invoice was created on a computer and is valid without the signature and seal.
                </footer>
            </div>
            <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
            <div></div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection