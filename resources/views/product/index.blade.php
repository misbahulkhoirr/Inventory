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
                            <h5 class="m-b-10">Product</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Product</a></li>
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
                        <h5>Data Product</h5>
                        <button type="button" class="btn btn-success btn-round has-ripple float-right" id="add-product" data-toggle="modal" data-target="#modal-product"><i class="feather icon-plus"></i> Add Product<span class="ripple ripple-animate" style="height: 109.734px; width: 109.734px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -31.047px; left: -9.12512px;"></span></button>
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
                                        <th>Product Code</th>
                                        <th>Kategori</th>
										<th>Nama Product</th>
										<th>Satuan</th>
                                        <th>Harga/Satuan</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($datas as $key => $data)
									<tr>
										<td>
											{{$key+1}}.
										</td>
                                        <td>{{$data->product_code}}</td>
                                        <td>{{$data->category->category}}</td>
										<td>{{$data->product_name}}</td>
										<td>{{$data->satuan->satuan}}</td>
										<td>{{number_format($data->price,0,',','.')}}</td>
                                        <td>
                                            <a href="javascript:void(0)" data-id="{{ $data->id }}" data-toggle="modal" data-target="#modal-product" class="btn btn-icon btn-success edit-product"><i class="icon feather icon-edit"></i></a>
                                            <a href="javascript:void(0)"data-id="{{ $data->id }}" class="btn btn-icon btn-danger delete-product"><i class="feather icon-trash-2"></i></a>
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
<div class="modal fade" id="modal-product" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-product"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addedit-product" name="addedit-product" class="form-horizontal" method="POST">
                    <div class="form-group">
                        <label for="product_code" class="form-label">Product Code:</label>
                        <input type="text" class="form-control" name="product_code" id="product_code" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select class="form-control" name="category_product_id" id="category_product_id">
                        <option value="">Select Category</option>
                        @foreach($category as $category)
                        @if (old('category_product_id')==$category->id)
                            <option value="{{$category->id }}" selected>{{$category->category}}</option>
                        @else 
                            <option value="{{$category->id }}">{{$category->category}}</option>
                        @endif
                        @endforeach
                        </select>
                        <span class="text-danger">
                            <strong id="category_product_id-error"></strong>
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label for="product_name" class="form-label">Product Name:</label>
                        <input type="hidden" class="form-control" name="id" id="id">
                        <input type="text" class="form-control" name="product_name" id="product_name" required>
                        <span class="text-danger">
                            <strong id="product_name-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Satuan</label>
                        <select class="form-control" name="satuan_id" id="satuan_id">
                        <option value="">Select Satuan</option>
                        @foreach($satuans as $sat)
                        @if (old('satuan_id')==$sat->id)
                            <option value="{{$sat->id }}" selected>{{$sat->satuan}}</option>
                        @else 
                            <option value="{{$sat->id }}">{{$sat->satuan}}</option>
                        @endif
                        @endforeach
                        </select>
                        <span class="text-danger">
                            <strong id="satuan_id-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="price" class="form-label">Price:</label>
                        <input type="text" class="form-control" name="price" id="price">
                        <span class="text-danger">
                            <strong id="price-error"></strong>
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

//    // ADD CREATE PRODUK
    $('#add-product').click(function () {
        $('#addedit-product').trigger("reset");
        $( '#product_name-error').html('');
        $( '#category_product_id-error').html('');
        $( '#satuan_id-error').html('');
        $( '#price-error').html('');
        $('#title-product').html("Add Product");
        $.ajax({
            type:"GET",
            url: "{{ url('/product-code') }}",
            // data: { id: id },
            dataType: 'json',
            success: function(res){
                console.log(res);
                $('#product_code').val(res);
            }
        });
    });

    // EDIT PRODUK
    $('body').on('click', '.edit-product', function (){
        $('#title-product').html("Edit Product");
        $( '#product_name-error').html('');
        $( '#satuan_id-error').html('');
        $( '#price-error').html('');
        $('#btn-save').attr("id","btn-update");
        var id = $(this).data('id');
        
        $.ajax({
            type:"POST",
            url: "{{ url('product-edit') }}/"+id,
            data: { id: id },
            dataType: 'json',
            success: function(res){
                console.log(JSON.stringify(res));
                $('#id').val(res.id);
                $('#product_code').val(res.product_code);
                $('#product_name').val(res.product_name);
                $('#price').val(res.price);
                $('#category_product_id').val(res.category_product_id);
                $('#satuan_id').val(res.satuan_id);
            }
        });
    });

    // DELETE PRODUK
    $('body').on('click', '.delete-product', function (){
        if (confirm("Delete product?") == true) {
        var id = $(this).data('id');
        
        $.ajax({
            type:"POST",
            url: "{{ url('product-delete') }}/"+id,
            data: { id: id },
            dataType: 'json',
            success: function(res){
                window.location.reload();
            }
        });
        }
    });

    // STORE PRODUK
    $('body').on('click', '#btn-save', function (event) {
        var product_code = $("#product_code").val();
        var product_name = $("#product_name").val();
        var price = $("#price").val();
        var category_product_id = $("#category_product_id").val();
        var satuan_id = $("#satuan_id").val();
        $("#btn-save").html('Please Wait...');
        $("#btn-save"). attr("disabled", true);

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('/product-add') }}",
            data: {
                    product_code:product_code,
                    product_name:product_name,
                    satuan_id:satuan_id,
                    price:price,
                    category_product_id:category_product_id,
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
                    if(errors.product_name){
                        $( '#product_name-error' ).html( errors.product_name[0] );
                    }else{ $( '#product_name-error' ).html(''); }
                    if(errors.satuan){
                        $( '#satuan_id-error' ).html( errors.satuan_id[0] );
                    }else{ $( '#satuan_id-error' ).html(''); }
                    if(errors.price){
                        $( '#price-error' ).html( errors.price[0] );
                    }else{ $( '#price-error' ).html(''); }
                }
            $("#btn-save").html('Save');
            $("#btn-save"). attr("disabled", false);
            }
        });
    });

// UPDATE PRODUK
    $('body').on('click', '#btn-update', function (event) {
        var id = $("#id").val();
        var product_code = $("#product_code").val();
        var product_name = $("#product_name").val();
        var satuan_id = $("#satuan_id").val();
        var price = $("#price").val();
        var category_product_id = $("#category_product_id").val();
        $("#btn-save").html('Please Wait...');
        $("#btn-save"). attr("disabled", true);
   
         // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('/product-update') }}/"+id,
            data: {
            id:id,
            product_code:product_code,
            product_name:product_name,
            satuan_id:satuan_id,
            price:price,
            category_product_id:category_product_id,
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
                    if(errors.product_name){
                        $( '#product_name-error' ).html( errors.product_name[0] );
                        }else{ $( '#product_name-error' ).html(''); }
                    if(errors.satuan_id){
                        $( '#satuan_id-error' ).html( errors.satuan_id[0] );
                        }else{ $( '#satuan_id-error' ).html(''); }
                    if(errors.price){
                        $( '#price-error' ).html( errors.price[0] );
                        }else{ $( '#price-error' ).html(''); }
                }
            $("#btn-save").html('Save');
            $("#btn-save"). attr("disabled", false);
            }
        });
    });
});
</script>
@endpush
