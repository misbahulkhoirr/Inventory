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
                            <h5 class="m-b-10">Storage</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Storage</a></li>
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
                        <h5>Data Storage</h5>
                        <button type="button" class="btn btn-success btn-round has-ripple float-right" id="add-storage" data-toggle="modal" data-target="#modal-storage"><i class="feather icon-plus"></i> Add Storage<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button>
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
										<th>Label</th>
										<th>Name</th>
                                        <th>Temperature</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($storages as $key => $storage)
									<tr>
										<td>
											{{$key+1}}.
										</td>
										<td>{{$storage->label}}</td>
										<td>{{$storage->name}}</td>
										<td>{{$storage->temperature}}</td>
									
                                        <td>
                                            <a href="javascript:void(0)" data-id="{{ $storage->id }}" data-toggle="modal" data-target="#modal-storage" class="btn btn-icon btn-success edit-storage"><i class="icon feather icon-edit"></i></a>
                                            <a href="javascript:void(0)"data-id="{{ $storage->id }}" class="btn btn-icon btn-danger delete-storage"><i class="feather icon-trash-2"></i></a>
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
<div class="modal fade" id="modal-storage" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-storage"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addedit-storage" name="addedit-storage" class="form-horizontal" method="POST">
                    <div class="form-group">
                        <label for="label" class="form-label">Label :</label>
                        <input type="hidden" class="form-control" name="id" id="id">
                        <input type="text" class="form-control" name="label" id="label" required>
                        <span class="text-danger">
                            <strong id="label-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">Name :</label>
                        <input type="text" class="form-control " name="name" id="name">
                        <span class="text-danger">
                            <strong id="name-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="temperature" class="form-label">Temperature :</label>
                        <input type="text" class="form-control" name="temperature" id="temperature">
                        <span class="text-danger">
                            <strong id="temperature-error"></strong>
                        </span>
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
@endsection
@push('js')
<script type="text/javascript">
    $(document).ready( function($){
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

//    // ADD CREATE USER
    $('#add-storage').click(function () {
        $('#addedit-storage').trigger("reset");
        $( '#label-error').html('');$( '#name-error').html('');$( '#temperature-error').html('');
        $('#title-storage').html("Add Storage");
    });

    // EDIT USER
    $('body').on('click', '.edit-storage', function (){
        $('#title-storage').html("Edit storage");
        $( '#label-error').html('');$( '#name-error').html('');$( '#temperature-error').html('');
        $('#btn-save').attr("id","btn-update");
        var id = $(this).data('id');
        
        $.ajax({
            type:"POST",
            url: "{{ url('storage-edit') }}/"+id,
            data: { id: id },
            dataType: 'json',
            success: function(res){
                // console.log(res);
                $('#id').val(res.id);
                $('#label').val(res.label);
                $('#name').val(res.name);
                $('#temperature').val(res.temperature);
            }
        });
    });

    // DELETE USER
    $('body').on('click', '.delete-storage', function (){
        if (confirm("Delete storage?") == true) {
        var id = $(this).data('id');
        
        $.ajax({
            type:"POST",
            url: "{{ url('storage-delete') }}/"+id,
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
        var label = $("#label").val();
        var name = $("#name").val();
        var temperature = $("#temperature").val();
        $("#btn-save").html('Please Wait...');
        $("#btn-save"). attr("disabled", true);

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('/storage-add') }}",
            data: {
                    label:label,
                    name:name,
                    temperature:temperature,
            },
                dataType: 'json',
                success: function(res){
                window.location.reload();
                $("#btn-save").html('Submit');
                $("#btn-save"). attr("disabled", false);
            
            },
            error: function(res) {
            var errors = res.responseJSON.errors
            console.log(errors)
            if(errors) {
                    if(errors.label){
                        $( '#label-error' ).html( errors.label[0] );
                    }else{ $( '#label-error' ).html(''); }
                    if(errors.name){
                        $( '#name-error' ).html( errors.name[0] );
                    }else{ $( '#name-error' ).html(''); }
                    if(errors.temperature){
                        $( '#temperature-error' ).html( errors.temperature[0] );
                    }else{ $( '#temperature-error' ).html(''); }
                }
            $("#btn-save").html('Save');
            $("#btn-save"). attr("disabled", false);
            }
        });
    });

// UPDATE USER
    $('body').on('click', '#btn-update', function (event) {
        var id = $("#id").val();
        var label = $("#label").val();
        var name = $("#name").val();
        var temperature = $("#temperature").val();
        $("#btn-save").html('Please Wait...');
        $("#btn-save"). attr("disabled", true);
   
         // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('/storage-update') }}/"+id,
            data: {
            id:id,
            label:label,
            name:name,
            temperature:temperature,
            },
            dataType: 'json',
            success: function(res){
            window.location.reload();
            $("#btn-save").html('Submit');
            $("#btn-save"). attr("disabled", false);
            },
            error: function(res) {
            var errors = res.responseJSON.errors
            console.log(errors);
            if(errors) {
                    if(errors.label){
                        $( '#label-error' ).html( errors.label[0] );
                    }else{ $( '#label-error' ).html(''); }
                    if(errors.name){
                        $( '#name-error' ).html( errors.name[0] );
                    }else{ $( '#name-error' ).html(''); }
                    if(errors.temperature){
                        $( '#temperature-error' ).html( errors.temperature[0] );
                    }else{ $( '#temperature-error' ).html(''); }
                }
            $("#btn-save").html('Save');
            $("#btn-save"). attr("disabled", false);
            }
        });
    });
});
</script>
@endpush
