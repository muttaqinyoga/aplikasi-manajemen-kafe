@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white text-center">
                    @if(Auth::user()->role==62)
                    <h5>Data Pesanan</h5>
                    @else
                    <h5>Data Pesanan oleh saya</h5>
                    @endif
                </div>

                <div class="card-body">
                    <div id="message" style="width: 50% !important;">
                        @if($message=Session::get('message'))
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                {{$message}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>                                     
                        </div>
                         @endif
                    </div>
                    <button type="button" class="btn btn-info mb-3 text-white" data-toggle="modal" data-target="#addOrderModal">Buat Pesanan Baru</button>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered" id="orderDataTable">
                            <thead class="text-white" style="background-color: #00796b!important;">
                                <th>No. Pesanan</th>
                                <th>No. Meja</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                @if(Auth::user()->role == 62)
                                <th>Dibuat oleh</th>
                                @endif
                                <th>Waktu Pemesanan</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody id="orderData">
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
<!-- Add Order Modal -->
<div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="addOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="addOrderModalLabel">Buat Pesanan baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="saveOrder">
            @csrf
        <div id="orderMenu">
            <div class="form-group">
                <label for="menu_id" class="col-form-label">Menu Pesanan</label>
                <select class="form-control" id="menu_id" name="menu_id">
                  <option selected value="">-- Pilih Menu --</option>
                  @foreach($menu as $m)
                  <option value="{{$m->uid}}">{{$m->menu_name}} ( Rp. {{number_format($m->menu_price,0,',','.')}} )</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="quantity_ordered" class="col-form-label">Jumlah</label>
                <input type="number" class="form-control" id="quantity_ordered" name="quantity_ordered">
            </div>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-dark" id="moreOrder">+</button>  
        </div>
        <div class="form-group">
            <label for="table_number" class="col-form-label">Nomor Meja</label>
            <select class="form-control" id="table_number" name="table_number">

            </select>
        </div>
        <input type="hidden" name="_nOrder" id="_nOrder" value="1">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-info text-white" id="saveOrderBtn">
            Simpan
        </button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- End Add Order Modal -->

<!-- Delete Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" role="dialog" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white" id="cancelOrderModalLabel">Batalkan Pesanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="cancelOrderContent">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <form method="post" style="display: inline;" id="cancelOrderForm">
            <input type="hidden" name="orderID" id="orderID">
            <button type="submit" class="btn btn-danger" id="cancelOrderBtn">Batalkan</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Delete Order Modal -->
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            loadOrder();
            getTables();
            var i = 1;
            $(document).on('click', '#moreOrder', function(){
                i++;
                $('#_nOrder').val(i);
                $('#orderMenu').after(`<div class="form-group" id="menu${i}">
                                            <label for="menu_id${i}" class="col-form-label">Menu Pesanan</label>
                                            <select class="form-control" id="menu_id${i}" name="menu_id${i}">
                                              <option selected value="">-- Pilih Menu --</option>
                                              @foreach($menu as $m)
                                              <option value="{{$m->uid}}">{{$m->menu_name}} ( Rp. {{number_format($m->menu_price,0,',','.')}} )</option>
                                              @endforeach
                                            </select>
                                          </div>
                                          <div class="form-group" id="jumlah${i}">
                                            <label for="quantity_ordered${i}" class="col-form-label">Jumlah</label>
                                            <input type="number" class="form-control" id="quantity_ordered${i}" name="quantity_ordered${i}">
                                          </div>
                                          <div class="form-group">
                                            <button type="button" id="lessOrder${i}" class="btn btn-danger lessOrder">-</button>  
                                          </div>
                                          `);
                
            });
            $(document).on('click', '.lessOrder', function(){
                removeOrder($(this).attr('id'));
                $(this).remove();
            });
             // Delete Menu
            $(document).on('click', '#cancelOrder', function(){
                const orderID = $(this).attr('orderID');
                const invoiceNumber = $(this).attr('invoiceNumber');
                const tableNumber = $(this).attr('tableNumber');
                $('#cancelOrderModal #cancelOrderContent').html(`<p>Batalkan pesanan dengan no. <strong>${invoiceNumber} Meja ${tableNumber}</strong>?</p>`);
                $('#cancelOrderModal #cancelOrderForm #orderID').val(orderID);
            });
            $('#cancelOrderForm').on('submit', function(e){
                e.preventDefault();
                $('#cancelOrderBtn').attr('disabled', true);
                $('#cancelOrderBtn').addClass('text-dark');
                $('#cancelOrderBtn').html(`<span class="spinner-border"></span>
            Membatalkan pesanan...`);
                $.ajax({
                    url : `{{url('order/destroy')}}`,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: {"orderID":$('#orderID').val(),"_token": "{{ csrf_token() }}"},
                    success: function (result) {
                        window.setTimeout(function(){
                            $('#cancelOrderModal').modal('hide');
                            document.getElementById("cancelOrderForm").reset();
                            $('#message').html(result.success);
                            $('#cancelOrderBtn').removeClass('text-dark');
                            $('#cancelOrderBtn').html(`Batalkan`);
                            $('#cancelOrderBtn').attr('disabled', false);
                            getTables();
                            const orderTable = $('#orderDataTable').DataTable().clear().destroy();
                            loadOrder();
                        }, 500);
                    },
                    error: function(e){
                        document.location.href = `{{url('/pesanan')}}`;
                    }
                })
            });
            // Save Menu
            $('#saveOrder').on('submit',function(e){
                e.preventDefault();
                const url = `{{url('order/save')}}`;
                $('#saveOrderBtn').attr('disabled', true);
                $('#saveOrderBtn').addClass('text-dark');
                $('#saveOrderBtn').html(`<span class="spinner-border"></span>
            Menyimpan`);
                $.ajax({
                    url : url,
                    method : 'post',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(result){
                        window.setTimeout(function(){
                            $('#addOrderModal').modal('hide');
                            document.getElementById("saveOrder").reset();
                            $('#message').html(result.success);
                            $('#saveOrderBtn').removeClass('text-dark');
                            $('#saveOrderBtn').html(`Simpan`);
                            $('#saveOrderBtn').attr('disabled', false);
                            getTables();
                            const orderTable = $('#orderDataTable').DataTable().clear().destroy();
                            loadOrder();
                        },500);
                    },
                    error: function(err){
                        $('.invalid-feedback').remove();
                        $('.is-invalid').removeClass('is-invalid');
                        $('#saveOrderBtn').removeClass('text-dark');
                        $('#saveOrderBtn').html(`Simpan`);
                        $('#saveOrderBtn').attr('disabled', false);
                        if(err.status == 422){
                            $.each(err.responseJSON.errors, function (i, error) {
                                if(i == '_nOrder'){
                                    $('#addOrderModal').modal('hide');
                                    document.getElementById("saveOrder").reset();
                                    $('#message').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Gagal membuat pesanan! Terjadi kesalahan yang tak terduga</strong>
                                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>`);
                                } else{
                                    const el = $(document).find('[name="'+i+'"]');
                                    if(e)
                                    el.addClass('is-invalid')
                                    el.after($('<div class="invalid-feedback">'+error[0]+'</div>'));
                                }
                            });
                        } else{
                            $('#addOrderModal').modal('hide');
                            document.getElementById("saveOrder").reset();
                            $('#message').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Gagal membuat pesanan! Terjadi kesalahan yang tak terduga</strong>
                                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>`);
                            $('#saveOrderBtn').removeClass('text-dark');
                            $('#saveOrderBtn').html(`Simpan`);
                            $('#saveOrderBtn').attr('disabled', false);
                        }
                    }
                });
            });
        });
        function removeOrder(c){
            let n = c.slice(-1);
            $('#jumlah'+n).remove();
            $('#menu'+n).remove();
        }
        function loadOrder(){
                const url = `{{url('order/data')}}`;;
                $.ajax({
                    url : url,
                    method : 'get',
                    success: function(data){
                        $('#loading').html(`<div class="spinner-borders"></div>`);
                        window.setTimeout(function(){
                            $('#loading').html('');
                            $('#orderData').html(data);
                            if(`{{Auth::user()->role}}` == '62'){
                                const orderTable = $('#orderDataTable').DataTable({
                                    "columnDefs": [
                                        { "orderable": false, "targets": 6 }
                                      ],
                                  "order": [
                                    [0, 'desc']
                                  ]
                                });
                            }else{
                                const orderTable = $('#orderDataTable').DataTable({
                                    "columnDefs": [
                                        { "orderable": false, "targets": 5 }
                                      ],
                                  "order": [
                                    [0, 'desc']
                                  ]
                                });
                            }
                        }, 500);
                    }
                });
            }
        function getTables(){
            const url = `{{url('order/tables/get')}}`;;
            $.ajax({
                url : url,
                method : 'get',
                success: function(data){
                    $('#table_number').html(data);
                }
            });
        }
    </script>
@endsection
