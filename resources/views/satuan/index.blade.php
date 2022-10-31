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
                            <h5 class="m-b-10">Satuan Product</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Satuan Product</a></li>
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
                        <h5>Data Satuan Product</h5>
                        <button type="button" class="btn btn-success btn-round has-ripple float-right" id="add-satuan" data-toggle="modal" data-target="#modal-satuan"><i class="feather icon-plus"></i> Add<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button>
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
										<th>Satuan</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($satuans as $key => $sat)
									<tr>
										<td>
											{{$key+1}}.
										</td>
										<td>{{$sat->satuan}}</td>
                                        <td>
                                            <a href="javascript:void(0)" data-id="{{ $sat->id }}" data-toggle="modal" data-target="#modal-satuan" class="btn btn-icon btn-success edit"><i class="icon feather icon-edit"></i></a>
                                            <a href="javascript:void(0)"data-id="{{ $sat->id }}" class="btn btn-icon btn-danger delete"><i class="feather icon-trash-2"></i></a>
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
<div class="modal fade" id="modal-satuan" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-satuan"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addedit-satuan" name="addedit-satuan" class="form-horizontal" method="POST">
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="id" id="id">
                        <label for="label" class="form-label">Satuan :</label>
                        <input type="text" class="form-control" name="satuan" id="satuan" required>
                        <span class="text-danger">
                            <strong id="satuanError"></strong>
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
   
       // ADD CATEGORY
       $('#add-satuan').click(function () {
          $('#addedit-satuan').trigger("reset");
          $( '#satuanError').html('');
          $('#title-satuan').html("Add Satuan");
       });
   
       // EDIT CATEGORY
       $('body').on('click', '.edit', function (){
         $('#title-satuan').html("Edit Satuan");
         $( '#satuanError').html('');
         $('#btn-save').attr("id","btn-update");
           var id = $(this).data('id');
           console.log('id = ' + id);
           
           $.ajax({
               type:"POST",
               url: "{{ url('satuan-edit') }}/"+id,
               data: { id: id },
               dataType: 'json',
               success: function(res){
                   console.log(res);
                 $('#satuan').val(res.satuan);
                 $('#id').val(res.id);
              }
           });
       });
   
       // DELETE CATEGORY
       $('body').on('click', '.delete', function (){
          if (confirm("Delete satuan ?") == true) {
           var id = $(this).data('id');
          
           $.ajax({
               type:"POST",
               url: "{{ url('satuan-delete') }}/"+id,
               data: { id: id },
               dataType: 'json',
               success: function(res){
                 window.location.reload();
              }
           });
          }
       });
   
       // STORE CATEGORY
       $('body').on('click', '#btn-save', function (event) {
           
             var satuan = $("#satuan").val();
             $("#btn-save").html('Please Wait...');
             $("#btn-save"). attr("disabled", true);
   
           // ajax
           $.ajax({
               type:"POST",
               url: "{{ url('/satuan-add') }}",
               data: {
              
                 satuan:satuan,
                
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
                    if(errors.satuan){
                        $( '#satuanError' ).html( errors.satuan[0] );
                    }else{ $( '#satuanError' ).html(''); }
                   
                }
                   
               $("#btn-save").html('Save');
               $("#btn-save"). attr("disabled", false);
               }
           });
       });
   
   // UPDATE CATEGORY
       $('body').on('click', '#btn-update', function (event) {
           var id = $("#id").val();
           var satuan = $("#satuan").val();
           $("#btn-save").html('Please Wait...');
           $("#btn-save"). attr("disabled", true);
   
         // ajax
         $.ajax({
             type:"POST",
             url: "{{ url('/satuan-update') }}/"+id,
             data: {
               id:id,
               satuan:satuan,
              
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
                if(errors.satuan){
                           $( '#satuanError' ).html( errors.satuan[0] );
                       }else{ $( '#satuanError' ).html(''); }
                   }
               $("#btn-save").html('Save');
               $("#btn-save"). attr("disabled", false);
               }
         });
     });
   });
   </script>


@endpush
