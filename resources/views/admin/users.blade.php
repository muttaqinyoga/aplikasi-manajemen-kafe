@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h5>Data Users Aplikasi </h5>
                </div>

                <div class="card-body">
                    <div id="message" style="width: 50% !important;">
                        
                    </div>
                    <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addUserModal">Buat User baru</button>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered" id="userDataTable">
                            <thead class="bg-dark text-white">
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Waktu Registrasi</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody id="usersData">
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
<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title text-white" id="addUserModalLabel">Buat User baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="saveUser">
            @csrf
          <div class="form-group">
            <label for="name" class="col-form-label">Nama</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="form-group">
            <label for="email" class="col-form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email">
          </div>
          <div class="form-group">
            <label for="password" class="col-form-label">Password</label>
            <input type="text" class="form-control" id="password" name="password">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- End Add User Modal -->
<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="editUserModalLabel">Ubah Data User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="updateUser">
            <input type="hidden" class="form-control" id="editID" name="editID">
          <div class="form-group">
            <label for="editName" class="col-form-label">Nama</label>
            <input type="text" class="form-control" id="editName" name="editName">
          </div>
          <div class="form-group">
            <label for="editEmail" class="col-form-label">Email</label>
            <input type="text" class="form-control" id="editEmail" name="editEmail">
          </div>
          <div class="form-group">
            <label for="editPassword" class="col-form-label">Password</label>
            <small class="text-danger">*Biarkan kosong jika tidak ingin mengubah password</small>
            <input type="text" class="form-control" id="editPassword" name="editPassword">
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
<!-- End Edit User Modal -->
<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white" id="deleteUserModalLabel">Hapus User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="deleteUserContent">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <form method="post" style="display: inline;" id="deleteUser">
            <input type="hidden" name="userID" id="userID">
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Delete User Modal -->
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            loadUser();
            // Edit User
            $(document).on('click', '#btnEditUser', function(){
                const editUserID = $(this).attr('edit_user_id');
                const editUserName = $(this).attr('edit_user_name');
                const editUserEmail = $(this).attr('edit_user_email');
                $('#editUserModal #editID').val(editUserID);
                $('#editUserModal #editName').val(editUserName);
                $('#editUserModal #editEmail').val(editUserEmail);
            });
            $('#updateUser').on('submit', function(e){
                e.preventDefault();
                const url = `{{url('admin/users/update')}}`;
                $.ajax({
                    url : url,
                    type : 'PUT',
                    dataType: 'json',
                    headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: { editID: $('#editID').val(), editName: $('#editName').val(), editEmail: $('#editEmail').val(), editPassword: $('#editPassword').val(), "_token": "{{ csrf_token() }}" },
                    success: function(result){
                        $('#editUserModal').modal('hide');
                        document.getElementById("updateUser").reset();
                        $('#message').html(result.success);
                        const userTable = $('#userDataTable').DataTable().clear().destroy();
                        loadUser();
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
                })
            });
            // Delete User
            $(document).on('click', '#btnDeleteUser', function(){
                const userID = $(this).attr('user_id');
                const userName = $(this).attr('user_name');
                $('#deleteUserModal #deleteUserContent').html(`<p>Hapus User <strong>${userName}</strong> dari aplikasi?</p>`);
                $('#deleteUserModal #deleteUser #userID').val(userID);
            });
            $('#deleteUser').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url : `{{url('admin/users/destroy')}}`,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: {userID:$('#userID').val(),"_token": "{{ csrf_token() }}"},
                    success: function (result) {
                        $('#deleteUserModal').modal('hide');
                        document.getElementById("deleteUser").reset();
                        $('#message').html(result.success);
                        const userTable = $('#userDataTable').DataTable().clear().destroy();
                        loadUser();
                    }
                })
            });
            // Save User
            $('#saveUser').on('submit',function(e){
                e.preventDefault();
                const url = `{{url('admin/users/save')}}`;
                $.ajax({
                    url : url,
                    method : 'post',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(result){
                        $('#addUserModal').modal('hide');
                        document.getElementById("saveUser").reset();
                        $('#message').html(result.success);
                        const userTable = $('#userDataTable').DataTable().clear().destroy();
                        loadUser();
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
        function loadUser(){
                const url = `{{url('admin/users/data')}}`;;
                $.ajax({
                    url : url,
                    method : 'get',
                    success: function(data){
                        $('#loading').html(`<div class="spinner-borders"></div>`);
                        window.setTimeout(function(){
                            $('#loading').html(``);
                            $('#usersData').html(data);
                            const userTable = $('#userDataTable').DataTable({
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