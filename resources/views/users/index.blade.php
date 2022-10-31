@extends('layouts.panel')
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
@endpush
@section('content')
<section class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Users</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Users</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- Basic Header fix table start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Data User</h5>
                        <button type="button" class="btn btn-success btn-round has-ripple float-right" id="add-user" data-toggle="modal" data-target="#modal-user"><i class="feather icon-plus"></i> Add User<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button>
                       
                    </div>
                    <div class="card-body">
                        @if (session()->has('message'))
                        <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        @endif
                        <div class="dt-responsive table-responsive">
                            <table id="fix-header" class="table table-striped table-bordered nowrap">
								<thead>
									<tr>
										<th>#</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Action</th>
									</tr>
								</thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}.</td>
                                        <td>{{ $user->name}}</td>
                                        <td>{{ $user->username}}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->role->name }}</td>
                                        <td>
                                            <a href="javascript:void(0)" data-id="{{ $user->id }}" data-toggle="modal" data-target="#modal-user" class="btn btn-icon btn-success edit"><i class="icon feather icon-edit"></i></a>
                                            <a href="javascript:void(0)"data-id="{{ $user->id }}" class="btn btn-icon btn-danger delete"><i class="feather icon-trash-2"></i></a>
                                        </td>
                                    </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</section>

<!-- [ varying-modal ] start -->			
<div class="modal fade" id="modal-user" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-user"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addedit-user" name="addedit-user" class="form-horizontal" method="POST">
                    <div class="form-group">
                        <label for="name" class="form-label">Nama:</label>
                        <input type="hidden" class="form-control" name="id" id="id">
                        <input type="text" class="form-control" name="name" id="name" required>
                        <span class="text-danger">
                            <strong id="name-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                        <span class="text-danger">
                            <strong id="username-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control " name="email" id="email">
                        <span class="text-danger">
                            <strong id="email-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" value="">
                        <span class="text-danger">
                            <strong id="password-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="form-label">phone:</label>
                        <input type="text" class="form-control" name="phone" id="phone">
                        <span class="text-danger">
                            <strong id="phone-error"></strong>
                        </span>
                    </div>
                   
                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <select class="form-control" name="role_id" id="role_id">
                        @foreach($roles as $role)
                        @if (old('role_id')==$role->id)
                            <option value="{{$role->id }}" selected>{{$role->name}}</option>
                        @else 
                            <option value="{{$role->id }}">{{$role->name}}</option>
                        @endif
                        @endforeach
                           
                        </select>
                    </div>
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- [ varying-modal ] end -->

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
 $(document).ready( function($){
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ADD CREATE USER
    $('#add-user').click(function () {
       $('#addedit-user').trigger("reset");
       $( '#name-error').html('');$( '#username-error').html('');$( '#email-error').html('');$( '#password-error').html('');$( '#phone-error').html('');
       $('#title-user').html("Add User");
    });

    // EDIT USER
    $('body').on('click', '.edit', function (){
      $('#title-user').html("Edit User");
      $( '#name-error').html('');$( '#username-error').html('');$( '#email-error').html('');$( '#password-error').html('');$( '#phone-error').html('');
      $('#btn-save').attr("id","btn-update");
        var id = $(this).data('id');
        
        $.ajax({
            type:"POST",
            url: "{{ url('users-edit') }}/"+id,
            data: { id: id },
            dataType: 'json',
            success: function(res){
                // console.log(res);
              $('#id').val(res.id);
              $('#name').val(res.name);
              $('#username').val(res.username);
              $('#email').val(res.email);
              $('#password').val(res.password);
              $('#phone').val(res.phone);
              $('#role_id').val(res.role_id);
           }
        });
    });

    // DELETE USER
    $('body').on('click', '.delete', function (){
       if (confirm("Delete user?") == true) {
        var id = $(this).data('id');
       
        $.ajax({
            type:"POST",
            url: "{{ url('users-delete') }}/"+id,
            data: { id: id },
            dataType: 'json',
            success: function(res){
              window.location.reload();
           }
        });
       }
    });

    // STORE USER
    $('body').on('click', '#btn-save', function (event) {
        
          var name = $("#name").val();
          var username = $("#username").val();
          var email = $("#email").val();
          var password = $("#password").val();
          var phone = $("#phone").val();
          var role_id = $("#role_id").val();
          $("#btn-save").html('Please Wait...');
          $("#btn-save"). attr("disabled", true);

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('/users-add') }}",
            data: {
           
              name:name,
              username:username,
              email:email,
              password:password,
              phone:phone,
              role_id:role_id,
            },
            dataType: 'json',
            success: function(res){
             window.location.reload();
            $("#btn-save").html('Submit');
            $("#btn-save"). attr("disabled", false);
           
           },
           error: function(res) {
            var errors = res.responseJSON.errors
            console.log(errors.name);
            if(errors) {
                    if(errors.name){
                        $( '#name-error' ).html( errors.name[0] );
                    }else{ $( '#name-error' ).html(''); }
                    if(errors.username){
                        $( '#username-error' ).html( errors.username[0] );
                    }else{ $( '#username-error' ).html(''); }
                    if(errors.email){
                        $( '#email-error' ).html( errors.email[0] );
                    }else{ $( '#email-error' ).html(''); }
                    if(errors.password){
                        $( '#password-error' ).html( errors.password[0] );
                    }else{ $( '#password-error' ).html(''); }
                    if(errors.phone){
                        $( '#phone-error' ).html( errors.phone[0] );
                    }else{ $( '#phone-error' ).html(''); }
                }
            $("#btn-save").html('Save');
            $("#btn-save"). attr("disabled", false);
            }
        });
    });

// UPDATE USER
    $('body').on('click', '#btn-update', function (event) {
        var id = $("#id").val();
        var name = $("#name").val();
        var username = $("#username").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var phone = $("#phone").val();
        var role_id = $("#role_id").val();
        $("#btn-save").html('Please Wait...');
        $("#btn-save"). attr("disabled", true);

      // ajax
      $.ajax({
          type:"POST",
          url: "{{ url('/users-update') }}/"+id,
          data: {
            id:id,
            name:name,
            username:username,
            email:email,
            password:password,
            phone:phone,
            role_id:role_id,
          },
          dataType: 'json',
          success: function(res){
           window.location.reload();
          $("#btn-save").html('Submit');
          $("#btn-save"). attr("disabled", false);
         },
         error: function(res) {
            var errors = res.responseJSON.errors
            // console.log(errors);
            if(errors) {
                    if(errors.name){
                        $( '#name-error' ).html( errors.name[0] );
                    }else{ $( '#name-error' ).html(''); }
                    if(errors.username){
                        $( '#username-error' ).html( errors.username[0] );
                    }else{ $( '#username-error' ).html(''); }
                    if(errors.email){
                        $( '#email-error' ).html( errors.email[0] );
                    }else{ $( '#email-error' ).html(''); }
                    if(errors.password){
                        $( '#password-error' ).html( errors.password[0] );
                    }else{ $( '#password-error' ).html(''); }
                    if(errors.phone){
                        $( '#phone-error' ).html( errors.phone[0] );
                    }else{ $( '#phone-error' ).html(''); }
                }
            $("#btn-save").html('Save');
            $("#btn-save"). attr("disabled", false);
            }
      });
  });
});
</script>



@endsection