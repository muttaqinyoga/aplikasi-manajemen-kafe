@extends('layouts.app')
@section('content')
<div class="d-flex flex-row justify-content-center">
 <div class="col-md-6 text-center">
	 <div class="alert alert-danger">
	 	<h1>404</h1>
	 	<h4>Halaman tidak ditemukan</h4>
	 </div>
	 <a href="{{url('/')}}" class="btn btn-primary">Kembali ke beranda</a>
 </div>
</div>
@endsection