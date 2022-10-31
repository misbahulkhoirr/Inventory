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
                            <h5 class="m-b-10">Category Product</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Category Product</a></li>
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
                        <h5>Data Category Product</h5>
                        <button type="button" class="btn btn-success btn-round has-ripple float-right" id="add-category" data-toggle="modal" data-target="#modal-category"><i class="feather icon-plus"></i> Add<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button>
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
										<th>Category</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($categorys as $key => $category)
									<tr>
										<td>
											{{$key+1}}.
										</td>
										<td>{{$category->category}}</td>
                                        <td>
                                            <a href="javascript:void(0)" data-id="{{ $category->id }}" data-toggle="modal" data-target="#modal-category" class="btn btn-icon btn-success edit"><i class="icon feather icon-edit"></i></a>
                                            <a href="javascript:void(0)"data-id="{{ $category->id }}" class="btn btn-icon btn-danger delete"><i class="feather icon-trash-2"></i></a>
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
<div class="modal fade" id="modal-category" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-category"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addedit-category" name="addedit-category" class="form-horizontal" method="POST">
                    <div class="form-group">
                        <label for="label" class="form-label">Category :</label>
                        <input type="hidden" class="form-control" name="id" id="id">
                        <input type="text" class="form-control" name="category" id="category" required>
                        <span class="text-danger">
                            <strong id="categoryError"></strong>
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
       $('#add-category').click(function () {
          $('#addedit-category').trigger("reset");
          $( '#categoryError').html('');
          $('#title-category').html("Add Category");
       });
   
       // EDIT CATEGORY
       $('body').on('click', '.edit', function (){
         $('#title-category').html("Edit Category");
         $( '#categoryError').html('');
         $('#btn-save').attr("id","btn-update");
           var id = $(this).data('id');
           
           $.ajax({
               type:"POST",
               url: "{{ url('category-edit') }}/"+id,
               data: { id: id },
               dataType: 'json',
               success: function(res){
                //    console.log(res);
                 $('#id').val(res.id);
                 $('#category').val(res.category);
              }
           });
       });
   
       // DELETE CATEGORY
       $('body').on('click', '.delete', function (){
          if (confirm("Delete category ?") == true) {
           var id = $(this).data('id');
          
           $.ajax({
               type:"POST",
               url: "{{ url('category-delete') }}/"+id,
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
           
             var category = $("#category").val();
             $("#btn-save").html('Please Wait...');
             $("#btn-save"). attr("disabled", true);
   
           // ajax
           $.ajax({
               type:"POST",
               url: "{{ url('/category-add') }}",
               data: {
              
                 category:category,
                
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
                    if(errors.category){
                        $( '#categoryError' ).html( errors.category[0] );
                    }else{ $( '#categoryError' ).html(''); }
                   
                }
                   
               $("#btn-save").html('Save');
               $("#btn-save"). attr("disabled", false);
               }
           });
       });
   
   // UPDATE CATEGORY
       $('body').on('click', '#btn-update', function (event) {
           var id = $("#id").val();
           var category = $("#category").val();
           $("#btn-save").html('Please Wait...');
           $("#btn-save"). attr("disabled", true);
   
         // ajax
         $.ajax({
             type:"POST",
             url: "{{ url('/category-update') }}/"+id,
             data: {
               id:id,
               category:category,
              
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
                if(errors.category){
                           $( '#categoryError' ).html( errors.category[0] );
                       }else{ $( '#categoryError' ).html(''); }
                   }
               $("#btn-save").html('Save');
               $("#btn-save"). attr("disabled", false);
               }
         });
     });
   });
   </script>


@endpush
