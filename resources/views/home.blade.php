@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <h3 class="font-weight-bold text-center p-2">Price Comparison</h3>

                <div class="card-body">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <h3 class="font-weight-bold p-2 text-center">Invoice Count</h3>

                <div class="card-body">
                    {!! $chart2->container() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h3 class="font-weight-bold p-2 text-center">Brand Performance</h3>
                <div class="card-body">
                    {!! $chart3->container() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {!! $chart->script() !!}
    {!! $chart2->script() !!}
    {!! $chart3->script() !!}
@endsection