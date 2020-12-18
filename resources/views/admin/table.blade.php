@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-danger text-center text-white">
                    <h5>Data Meja</h5>
                </div>

                <div class="card-body">
                    <div id="message" style="width: 50% !important;">
                        
                    </div>
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addTableModal">Tambah Meja Baru</button>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered" id="tableDataTable">
                            <thead class="bg-warning text-dark">
                                <th>No. Meja</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody id="tableData">
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
<!-- Add Table Modal -->
<div class="modal fade" id="addTableModal" tabindex="-1" role="dialog" aria-labelledby="addTableModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="addTableModalLabel">Tambah Meja baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="saveTable">
            @csrf
          <div class="form-group">
            <label for="table_number" class="col-form-label">Nomor Meja</label>
            <input type="number" class="form-control" id="table_number" name="table_number">
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
<!-- End Add Table Modal -->
<!-- Edit Table Modal -->
<div class="modal fade" id="editTableModal" tabindex="-1" role="dialog" aria-labelledby="editTableModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="editTableModalLabel">Ubah Data Meja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="updateTable">
            <input type="hidden" class="form-control" id="editTableID" name="editTableID">
          <div class="form-group">
            <label for="editTableNumber" class="col-form-label">Nomor Meja</label>
            <input type="text" class="form-control" id="editTableNumber" name="editTableNumber">
          </div>
          <div class="form-group">
            <label class="col-form-label d-block">Status</label>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="status1" name="editTableStatus" class="custom-control-input" value="Kosong">
              <label class="custom-control-label" for="status1">Kosong</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="status2" name="editTableStatus" class="custom-control-input" value="Telah dipesan">
              <label class="custom-control-label" for="status2">Telah dipesan</label>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">Ubah</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- End Edit Table Modal -->
<!-- Delete Table Modal -->
<div class="modal fade" id="deleteTableModal" tabindex="-1" role="dialog" aria-labelledby="deleteTableModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title text-white" id="deleteTableModalLabel">Hapus Meja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="deleteTableContent">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <form method="post" style="display: inline;" id="deleteTable">
            <input type="hidden" name="tableID" id="tableID">
            <button type="submit" class="btn btn-dark">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Delete Table Modal -->
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            loadTable();
            // Edit Table
            $(document).on('click', '#btnEditTable', function(){
                $('#editTableModal #status1').attr('checked', false);
                $('#editTableModal #status2').attr('checked', false);
                const editTableID = $(this).attr('edit_table_id');
                const editTableNumber = $(this).attr('edit_table_number');
                const editTableStatus = $(this).attr('edit_table_status');
                $('#editTableModal #editTableID').val(editTableID);
                $('#editTableModal #editTableNumber').val(editTableNumber);
                if(editTableStatus == 'Kosong'){
                    $('#editTableModal #status1').attr('checked', true);
                }else{
                    $('#editTableModal  #status2').attr('checked', true);
                }
            });
            $('#updateTable').on('submit', function(e){
                e.preventDefault();
                const url = `{{url('admin/table/update')}}`;
                $.ajax({
                    url : url,
                    type : 'PUT',
                    dataType: 'json',
                    headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: { editTableID: $('#editTableID').val(), editTableNumber: $('#editTableNumber').val(), editTableStatus: $('[name="editTableStatus"]:checked').val(), "_token": "{{ csrf_token() }}" },
                    success: function(result){
                        $('#editTableModal').modal('hide');
                        document.getElementById("updateTable").reset();
                        $('#message').html(result.success);
                        const menuTable = $('#tableDataTable').DataTable().clear().destroy();
                        loadTable();
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
            // Delete Table
            $(document).on('click', '#btnDeleteTable', function(){
                const tableID = $(this).attr('table_id');
                const tableNumber = $(this).attr('table_number');
                $('#deleteTableModal #deleteTableContent').html(`<p>Hapus Meja dengan Nomor <strong>${tableNumber}</strong> dari daftar Meja?</p>`);
                $('#deleteTableModal #deleteTable #tableID').val(tableID);
            });
            $('#deleteTable').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url : `{{url('admin/table/destroy')}}`,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: {tableID:$('#tableID').val(),"_token": "{{ csrf_token() }}"},
                    success: function (result) {
                        $('#deleteTableModal').modal('hide');
                        document.getElementById("deleteTable").reset();
                        $('#message').html(result.success);
                        const menuTable = $('#tableDataTable').DataTable().clear().destroy();
                        loadTable();
                    }
                })
            });
            // Save Table
            $('#saveTable').on('submit',function(e){
                e.preventDefault();
                const url = `{{url('admin/table/save')}}`;
                $.ajax({
                    url : url,
                    method : 'post',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(result){
                        $('#addTableModal').modal('hide');
                        document.getElementById("saveTable").reset();
                        $('#message').html(result.success);
                        const menuTable = $('#tableDataTable').DataTable().clear().destroy();
                        loadTable();
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
        function loadTable(){
                const url = `{{url('admin/table/data')}}`;;
                $.ajax({
                    url : url,
                    method : 'get',
                    success: function(data){
                        $('#loading').html(`<div class="spinner-borders"></div>`);
                        window.setTimeout(function(){
                            $('#loading').html('');
                            $('#tableData').html(data);
                            const menuTable = $('#tableDataTable').DataTable({
                                "columnDefs": [
                                    { "orderable": false, "targets": 2 }
                                  ]
                            });
                        }, 1000);
                    }
                });
            }
    </script>
@endsection