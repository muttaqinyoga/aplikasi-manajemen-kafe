@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white text-center">
                    <h5>Data Menu Makanan dan Minuman</h5>
                </div>

                <div class="card-body">
                    <div id="message" style="width: 50% !important;">
                        
                    </div>
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addMenuModal">Tambah Menu Baru</button>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered" id="menuDataTable">
                            <thead class="bg-dark text-white">
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Ketersediaan</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody id="menuData">
                            </tbody>
                        </table>
                    </div>
                    <div id="loading" class="row justify-content-center">
                        <div class="spinner-borders"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Menu Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="addMenuModalLabel">Tambah Menu baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="saveMenu">
            @csrf
          <div class="form-group">
            <label for="menu_name" class="col-form-label">Nama</label>
            <input type="text" class="form-control" id="menu_name" name="menu_name">
          </div>
          <div class="form-group">
            <label for="menu_price" class="col-form-label">Harga</label>
            <input type="number" class="form-control" id="menu_price" name="menu_price" placeholder="contoh : 10000">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- End Add Menu Modal -->
<!-- Edit Menu Modal -->
<div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="editMenuModalLabel">Ubah Data Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="updateMenu">
            <input type="hidden" class="form-control" id="editMenuID" name="editMenuID">
          <div class="form-group">
            <label for="editMenuName" class="col-form-label">Nama</label>
            <input type="text" class="form-control" id="editMenuName" name="editMenuName">
          </div>
          <div class="form-group">
            <label for="editMenuPrice" class="col-form-label">Harga</label>
            <input type="number" class="form-control" id="editMenuPrice" name="editMenuPrice">
          </div>
          <div class="form-group">
            <label class="col-form-label d-block">Ketersediaan</label>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="status1" name="editMenuStatus" class="custom-control-input" value="Tersedia">
              <label class="custom-control-label" for="status1">Tersedia</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="status2" name="editMenuStatus" class="custom-control-input" value="Tidak Tersedia">
              <label class="custom-control-label" for="status2">Tidak Tersedia</label>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning">Ubah</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- End Edit Menu Modal -->
<!-- Delete Menu Modal -->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white" id="deleteMenuModalLabel">Hapus Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="deleteMenuContent">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <form method="post" style="display: inline;" id="deleteMenu">
            <input type="hidden" name="menuID" id="menuID">
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Delete Menu Modal -->
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            loadMenu();
            $(document).on('click', '#btnEditMenu', function(){
                $('#editMenuModal #status1').attr('checked', false);
                $('#editMenuModal #status2').attr('checked', false);
                const editMenuID = $(this).attr('edit_menu_id');
                const editMenuName = $(this).attr('edit_menu_name');
                const editMenuPrice = $(this).attr('edit_menu_price');
                const editMenuStatus = $(this).attr('edit_menu_status');
                $('#editMenuModal #editMenuID').val(editMenuID);
                $('#editMenuModal #editMenuName').val(editMenuName);
                $('#editMenuModal #editMenuPrice').val(editMenuPrice);
                if(editMenuStatus == 'Tersedia'){
                    $('#editMenuModal #status1').attr('checked', true);
                }else{
                    $('#editMenuModal  #status2').attr('checked', true);
                }
            });
            $('#updateMenu').on('submit', function(e){
                e.preventDefault();
                const url = `{{url('admin/menu/update')}}`;
                $.ajax({
                    url : url,
                    type : 'PUT',
                    dataType: 'json',
                    headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: { editMenuID: $('#editMenuID').val(), editMenuName: $('#editMenuName').val(), editMenuPrice: $('#editMenuPrice').val(), editMenuStatus: $('[name="editMenuStatus"]:checked').val(), "_token": "{{ csrf_token() }}" },
                    success: function(result){
                        $('#editMenuModal').modal('hide');
                        document.getElementById("updateMenu").reset();
                        $('#message').html(result.success);
                        const menuTable = $('#menuDataTable').DataTable().clear().destroy();
                        loadMenu();
                    },
                    error: function(err){
                        $('.invalid-feedback').remove();
                        $('.is-invalid').removeClass('is-invalid');
                        if(err.status == 422){
                            $.each(err.responseJSON.errors, function (i, error) {
                                const el = $(document).find('[name="'+i+'"]');
                                if(e)
                                el.addClass('is-invalid')
                                el.after($('<div class="invalid-feedback">'+error[0]+'</div>'));
                            });
                        }
                    }
                });
            });
            // Delete Menu
            $(document).on('click', '#btnDeleteMenu', function(){
                const menuID = $(this).attr('menu_id');
                const menuName = $(this).attr('menu_name');
                $('#deleteMenuModal #deleteMenuContent').html(`<p>Hapus Menu <strong>${menuName}</strong> dari daftar Menu?</p>`);
                $('#deleteMenuModal #deleteMenu #menuID').val(menuID);
            });
            $('#deleteMenu').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url : `{{url('admin/menu/destroy')}}`,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: {menuID:$('#menuID').val(),"_token": "{{ csrf_token() }}"},
                    success: function (result) {
                        $('#deleteMenuModal').modal('hide');
                        document.getElementById("deleteMenu").reset();
                        $('#message').html(result.success);
                        const menuTable = $('#menuDataTable').DataTable().clear().destroy();
                        loadMenu();
                    }
                })
            });
            // Save Menu
            $('#saveMenu').on('submit',function(e){
                e.preventDefault();
                const url = `{{url('admin/menu/save')}}`;
                $.ajax({
                    url : url,
                    method : 'post',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(result){
                        $('#addMenuModal').modal('hide');
                        document.getElementById("saveMenu").reset();
                        $('#message').html(result.success);
                        const menuTable = $('#menuDataTable').DataTable().clear().destroy();
                        loadMenu();
                    },
                    error: function(err){
                        $('.invalid-feedback').remove();
                        $('.is-invalid').removeClass('is-invalid');
                        if(err.status == 422){
                            $.each(err.responseJSON.errors, function (i, error) {
                                const el = $(document).find('[name="'+i+'"]');
                                if(e)
                                el.addClass('is-invalid')
                                el.after($('<div class="invalid-feedback">'+error[0]+'</div>'));
                            });
                        }
                    }
                });
            });
        });
        function loadMenu(){
                const url = `{{url('admin/menu/data')}}`;;
                $.ajax({
                    url : url,
                    method : 'get',
                    success: function(data){
                        $('#loading').html(`<div class="spinner-borders"></div>`);
                        window.setTimeout(function(){
                            $('#loading').html('');
                            $('#menuData').html(data);
                            const menuTable = $('#menuDataTable').DataTable({
                                "columnDefs": [
                                    { "orderable": false, "targets": 4 }
                                  ]
                            });
                        }, 1000);
                    }
                });
            }
    </script>
@endsection