@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"> <h4 class="text-center">Dashboard</h4></div>

                <div class="card-body bg-dark">
                    <div class="card-deck">
                        <div class="card text-white bg-primary mb-3">
                          <div class="card-header"><h4 class="card-title text-center">Total pendapatan sementara pada hari ini</h4></div>
                          <div class="card-body">
                            <h2 class="card-title text-center">Rp {{ number_format($totalPayment[0]->paymentToday, 0,',','.') }}</h2>
                          </div>
                        </div>
                        <div class="card text-white bg-danger mb-3">
                          <div class="card-header"><h4 class="card-title text-center">Menu yang paling sering dipesan</h4></div>
                          <div class="card-body">
                            <ol>
                                @foreach($topFoods as $f)
                                 <li>{{ $f->menu_name }} ( {{$f->total}} )</li>
                                @endforeach
                            </ol>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
