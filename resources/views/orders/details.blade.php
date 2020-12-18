@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white text-center" style="background-color: #f57c00!important;">
                    <h6>Detail Pesanan dengan Nomor Meja {{$orders->first()->tableNumber}}</h6>
                    <p>Waktu pemesanan : {{date('d-m-Y H:i:s', strtotime($orders->first()->orderDate))}}  {{Auth::user()->role==62 ? 'dibuat oleh '.$orders->first()->createdBy : ''}}</p>
                </div>

                <div class="card-body">
                    @if($message=Session::get('message'))
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                {{$message}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>                                     
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Gagal mengedit pesanan. Data yang dikirim tidak valid.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>                                     
                        </div>
                    @endif
                    @if($orders->first()->orderStatus == 'Belum dibayar')
                    <form id="formEditTable" method="post" class="form-inline mb-3" action="{{url('/order/table/update')}}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id" value="{{$id}}">
                        <label for="edit_table_number" class="mr-2">Nomor Meja</label>
                        <select class="form-control mr-sm-2" id="edit_table_number" name="edit_table_number">
                            <option value="{{$orders->first()->tableID}}" selected>{{$orders->first()->tableNumber}}</option>
                            @foreach($tables as $t)
                                <option value="{{$t->uid}}">{{$t->table_number}}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary my-2 my-sm-0">Ubah</button>
                    </form>
                    <form id="formAddOrder" method="post" class="form-inline mb-3" action="{{url('order/add/'.$id)}}">
                        @csrf
                        @method('PUT')
                        <label for="add_new_menu" class="mr-2">Menu</label>
                        <select class="form-control mr-sm-2 {{$errors->has('add_new_menu') ? ' is-invalid' : '' }}" id="add_new_menu" name="add_new_menu">
                            <option value="" selected>-- Pilih Menu -- </option>
                            @foreach($menu as $m)
                                <option value="{{$m->uid}}">{{$m->menu_name}} ( Rp. {{number_format($m->menu_price,0,',','.')}} )</option>
                            @endforeach
                        </select>
                        @if ($errors->has('add_new_menu'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('add_new_menu') }}</strong>
                            </span>
                        @endif
                        <label for="quantity_new_menu" class="mr-2">Jumlah</label>
                        <input type="number" class="form-control mr-sm-2 {{$errors->has('quantity_new_menu') ? ' is-invalid' : '' }}" id="quantity_new_menu" name="quantity_new_menu" min="1" max="100">
                        @if ($errors->has('quantity_new_menu'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('quantity_new_menu') }}</strong>
                            </span>
                        @endif
                        <button type="submit" class="btn my-2 my-sm-0" style="background-color: #76ff03!important;">Tambah Pesanan</button>
                    </form>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered" id="orderDetailDataTable">
                            <thead class="bg-dark text-white">
                                <th>No.</th>
                                <th>Menu</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                @if($orders->first()->orderStatus == 'Belum dibayar')
                                <th>Aksi</th>
                                @endif
                            </thead>
                            <tbody id="orderDetailData">
                                @foreach($orders as $o)
                                <tr>
                                    <td>{{++$no}}</td>
                                    <td>{{ $o->menuName }}</td>
                                    <td>Rp. {{ number_format($o->menuPrice,0,',','.') }}</td>
                                    <td>{{ $o->quantityOrdered }}</td>
                                    @if($orders->first()->orderStatus == 'Belum dibayar')
                                    <td>
                                        <button type="button" class="btn btn-sm text-white" style="background-color: #00897b!important;" data-toggle="modal" data-target="#editMenuOrdered" menuID="{{$o->menuID}}" menuName="{{$o->menuName}}" id="editOrderedMenu" quantityOrdered="{{$o->quantityOrdered}}" orderDetailsID="{{$o->orderDetailsID}}" >Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#cancelMenuOrdered" menuName="{{$o->menuName}}" id="cancelOrderedMenu" quantityOrdered="{{$o->quantityOrdered}}" orderDetailsID="{{$o->orderDetailsID}}" >Batalkan</button>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h5>Total Pembayaran : Rp. {{number_format($orders->first()->totalPrice,0,',','.')}}
                    @if($orders->first()->orderStatus== 'Belum dibayar')
                    (<strong class="text-warning">Belum dibayar</strong>)
                    @elseif($orders->first()->orderStatus== 'Telah dibayar')
                    (<strong class="text-info">Telah dibayar</strong>)
                    <a href="{{url('invoice/'.$paymentID)}}" class="btn btn-primary btn-sm text-white" target="__blank">Cetak Bukti Pembayaran</a>
                    @else
                    (<strong class="text-danger">Dibatalkan</strong>)
                    @endif
                    </h5>
                    @if($orders->first()->orderStatus == 'Belum dibayar' && Auth::user()->role== 62)
                    <a class="btn text-white" href="{{url('admin/payment/'.$crypted_order_uid.'/create')}}" style="background-color: #6d4c41!important;">
                        Buat Pembayaran
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@if($orders->first()->orderStatus == 'Belum dibayar')
<!-- Add Order Modal -->
<div class="modal fade" id="editMenuOrdered" tabindex="-1" role="dialog" aria-labelledby="editMenuOrderedLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #00897b!important;">
        <h5 class="modal-title text-white" id="editMenuOrderedLabel">Edit Pesanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="updateMenuOrdered">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_menu_ordered_id" class="col-form-label">Menu Pesanan</label>
                <select class="form-control" id="edit_menu_ordered_id" name="edit_menu_ordered_id" required>
                </select>
            </div>
            <div class="form-group">
                <label for="edit_quantity_menu_ordered" class="col-form-label">Jumlah</label>
                <input type="number" class="form-control" id="edit_quantity_menu_ordered" name="edit_quantity_menu_ordered" required min="1" max="100">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success text-white" id="saveOrderBtn">
            Update
        </button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- End Order Menu Modal -->
<!-- Delete Order Modal -->
<div class="modal fade" id="cancelMenuOrdered" tabindex="-1" role="dialog" aria-labelledby="cancelMenuOrderedLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white" id="cancelMenuOrderedLabel">Batalkan Pesanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="contentCancelModal">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <form method="post" style="display: inline;" id="cancelOrderedForm">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Batalkan</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Delete Order Modal -->
@endif
@endsection
@if($orders->first()->orderStatus == 'Belum dibayar')
@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            // Edit
            $(document).on('click', '#editOrderedMenu', function(){
                const menuID = $(this).attr('menuID');
                const quantityOrdered = $(this).attr('quantityOrdered');
                const orderDetailsID = $(this).attr('orderDetailsID');
                $('#edit_menu_ordered_id').html(`
                        @foreach($menu as $m)
                            <option value="{{$m->uid}}" ${menuID==`{{$m->uid}}` ? 'selected' : ''} >{{$m->menu_name}} ( Rp. {{number_format($m->menu_price,0,',','.')}} )</option>
                        @endforeach
                    `); 
                $('#edit_quantity_menu_ordered').val(quantityOrdered);
                $('#updateMenuOrdered').attr('action', `{{url('order/update/'.$id.'/${orderDetailsID}')}}`);
            });
            // Delete
            $(document).on('click', '#cancelOrderedMenu', function(){
                const menuName = $(this).attr('menuName');
                const quantityOrdered = $(this).attr('quantityOrdered');
                const orderDetailsID = $(this).attr('orderDetailsID');
                $('#contentCancelModal').html(`<p>Batalkan pemesanan menu <strong>${menuName} (${quantityOrdered} porsi)</strong> ? </p>`);
                $('#cancelOrderedForm').attr('action', `{{url('order/destroy/'.$id.'/${orderDetailsID}')}}`);
            });
        });
    </script>
@endsection
@endif