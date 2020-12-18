@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white text-center" style="background-color: #00796b!important;">
                    @if(Auth::user()->role==62)
                    <h5>Data Pembayaran</h5>
                    @else
                    <h5>Data Pembayaran oleh saya</h5>
                    @endif
                </div>
                <div class="card-body">
                    @if($message=Session::get('message'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <p>{!!$message!!}</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>                                     
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered" id="paymentDataTable">
                            <thead class="bg-dark text-white" >
                                <th>No. Pesanan</th>
                                <th>Total Pembayaran</th>
                                <th>Jumlah dibayar</th>
                                <th>Jumlah kembalian</th>
                                <th>Waktu Pembayaran</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody id="paymentData">
                            </tbody>
                        </table>
                    </div>
                    <div id="loading" class="row justify-content-center">
                        <span class="spinner-borders"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            const url = `{{url('admin/payments/data')}}`;;
                $.ajax({
                    url : url,
                    method : 'get',
                    success: function(data){
                        $('#loading').html('');
                        $('#paymentData').html(data);
                            const paymentTable = $('#paymentDataTable').DataTable({
                                "columnDefs": [
                                    { "orderable": false, "targets": 5 }
                                  ],
                                  "order": [
                                    [0, 'desc']
                                  ]
                            });
                    }
                });
        });
    </script>
@endsection