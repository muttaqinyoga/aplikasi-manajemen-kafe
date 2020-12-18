<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    public function user()
    {
    	return view('admin.users');
    }
    public function getUsers()
    {
    	$users = User::orderBy('created_at')->get();
    	$no = 0;
    	$html = "";
    	foreach($users as $u)
    	{
    		$html .= "<tr>
                    <td>".++$no."</td>
                    <td>$u->name</td>
                    <td>$u->email</td>
                    <td>$u->created_at</td>
                    <td>";
           	if($u->role == 62)
           	{
           		$html .= '<button type="button" class="btn btn-warning btn-sm disabled">
                                Ubah
                            </button>
                            <button type="button" class="btn btn-danger btn-sm disabled">
                                Hapus
                            </button>';
           	}
           	else
           	{
           		$html .= '<button type="button" class="btn btn-warning btn-sm" id="btnEditUser" edit_user_id="'.$u->uid.'" edit_user_name="'.$u->name.'" edit_user_email="'.$u->email.'" data-toggle="modal" data-target="#editUserModal" >
                                Ubah
                            </button>
                            <button type="button" id="btnDeleteUser" user_id="'.$u->uid.'" user_name="'.$u->name.'" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUserModal">
                                Hapus
                            </button>';
           	}
           	$html .= "</td>
                    </tr>";
    	}
    	echo $html;
    }
    public function save(Request $request)
    {
    	$validation = \Validator::make($request->all(), [
    		'name' => 'required|min:5|max:50|string',
    		'email' => 'required|email|unique:users',
    		'password' => 'required|min:5'
    	])->validate();
    	
    	$user = new User;
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->password = bcrypt($request->password);
    	$user->role = 26;
    	$user->save();

    	return response()->json(['success' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
												  <strong>User baru berhasil dibuat</strong>
												  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    <span aria-hidden="true">&times;</span>
												  </button>
												</div>']);
    }
    public function update(Request $request)
    {
    	if(isset($request->editID))
    	{
    		$user = User::findOrFail($request->editID);
    		if($user->role == 62)
			{
				return response()->json(['success' => '<div class="alert alert-warning alert-dismissible fade show" role="alert">
											  <strong>Data user berhasil diubah</strong>
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											    <span aria-hidden="true">&times;</span>
											  </button>
											</div>']);
			}
    		if(is_null($request->editPassword))
    		{
    			$validation = \Validator::make($request->all(), [
		    		'editName' => 'required|min:5|max:50|string',
		    		'editEmail' => 'required|email|unique:users,email,'.$request->editID.',uid'
		    	])->validate();
		    	$user->name = $request->editName;
		    	$user->email = $request->editEmail;
		    	$user->update();
    		}
    		else
    		{
    			$validation = \Validator::make($request->all(), [
		    		'editName' => 'required|min:5|max:50|string',
		    		'editEmail' => 'required|email|unique:users,email,'.$request->editID.',uid',
		    		'editPassword' => 'required|min:5'
		    	])->validate();
		    	$user->name = $request->editName;
		    	$user->email = $request->editEmail;
		    	$user->password = bcrypt($request->editPassword);
		    	$user->update();
    		}
    		return response()->json(['success' => '<div class="alert alert-warning alert-dismissible fade show" role="alert">
												  <strong>Data user berhasil diubah</strong>
												  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    <span aria-hidden="true">&times;</span>
												  </button>
												</div>']);
    	}
    }
    public function delete(Request $request)
    {
    	if(isset($request->userID))
    	{
          $user = User::findOrFail($request->userID);
          if($user->role == 62)
          {
          	return response()->json(['success' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
													  User berhasil dihapus dari aplikasi
													  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
													    <span aria-hidden="true">&times;</span>
													  </button>
													</div>']);
          }
          $user->delete();
          return response()->json(['success' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
												  User <strong>'.$user->name.'</strong> berhasil dihapus dari aplikasi
												  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    <span aria-hidden="true">&times;</span>
												  </button>
												</div>']);
        }
    }
 
}
