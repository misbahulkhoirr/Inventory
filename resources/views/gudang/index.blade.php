@extends('layouts.panel')
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<style>
    .action-width{
        max-width:50px !important;
    }
</style>
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
                            <h5 class="m-b-10">Gudang</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Gudang</a></li>
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
                        <h5>Data Gudang</h5>
                        <button data-toggle="modal" data-target="#exampleModalLive" class="btn btn-success float-right"><i class="icon feather icon-plus f-w-600 f-16 text-c-white"> Add Gudang</i></button>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                 <strong>{{ $message }}</strong>
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                @endif

                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="alt-pg-dt" class="table table-striped table-bordered nowrap">
								<thead>
									<tr>
										<th>ID</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @if (count($gudangs) > 0)
                                    @foreach ($gudangs as $key => $gudang)
									<tr>
                                        <td>{{ ( $gudangs->currentPage() - 1 ) * $gudangs->perPage() + $key + 1 }}</td>
                                        <td>{{ $gudang->name }}</td>
                                        <td>{{ $gudang->alamat }}</td>
                                        <td>{{ $gudang->created_at }}</td>
                                        <td>{{ $gudang->updated_at }}</td>
                                        <td>
                                            <button  class="btn btn-icon btn-success edit-product" data-toggle="modal" data-target="#viewGudangModal" onClick="viewGudang({{ $gudang->id }})"><i class="icon feather icon-edit"></i></button>
                                            <form action="{{route('delete-gudang', $gudang->id)}}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-danger delete-product" onclick="myFunction()"><i class="feather icon-trash-2"></i></button>
                                            </form>
                                        </td>
									</tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6">No Data Available</td>
                                    </tr>
                                    @endif
								</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
      {{-- Add Modal --}}
      <div class="modal fade" id="exampleModalLive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLiveLabel">Add Gudang</h5>
                </div>
                <form method="POST" action="{{route('store-gudang')}}">
                @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputName" class="col-form-label">Name</label>
                            <input type="text" class="form-control" id="inputName" name="name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress" class="col-form-label">Address</label>
                            <input type="text" class="form-control" id="inputAddress" name="address" placeholder="Enter Address">
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"> Close </i></button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"> Save </i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        {{-- Edit Modal --}}
        <div class="modal fade" id="viewGudangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Gudang</h5>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="form-edit">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="editName" class="col-form-label">Name</label>
                                <input type="text" class="form-control" id="editName" name="name" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label for="editAddress" class="col-form-label">Address</label>
                                <input type="text" class="form-control" id="editAddress" name="address" placeholder="Enter Address">
                            </div>  
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"> Close </i></button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"> Save </i></button>
                    </div>
                </form>
                </div>
            </div>
        </div>
</section>
@endsection
@push('js')
<script src="{{asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>
<!-- Apex Chart -->
<script>
    // DataTable start
    $('#alt-pg-dt').DataTable();
    // DataTable end
</script>
<script>
    // Ajax View Edit Data
function viewGudang(id) {
    $('#form-edit').attr('action',"{{ url('/update-gudang') }}/"+id)

//View Modal
    $.ajax({
        type: "GET",
        url: "{{ url('/edit-gudang') }}/"+id,
        dataType:'JSON',
        success: function(response){

        $('#editName').val(response.gudang.name);
        $('#editAddress').val(response.gudang.alamat);

        }
    });
}

function myFunction() {
            if(!confirm("Are You Sure to delete this"))
            event.preventDefault();
        }

</script>
@endpush