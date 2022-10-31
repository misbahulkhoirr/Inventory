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
                            <h5 class="m-b-10">Supplier</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{route('supplier.index')}}">Supplier</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Data Supplier</h5>
                        <button data-toggle="modal" data-target="#exampleModalLive"
                            class="btn btn-success float-right"><i
                                class="icon feather icon-plus f-w-600 f-16 text-c-white"> Add Supplier </i></button>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
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
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
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
                                        <th>Phone</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($suppliers) > 0)
                                    @foreach ($suppliers as $key => $supplier)
                                    <tr>
                                        <td>{{ ( $suppliers->currentPage() - 1 ) * $suppliers->perPage() + $key + 1 }}.
                                        </td>
                                        <td>{{ $supplier->name }}</td>
                                        <td>{{ $supplier->alamat }}</td>
                                        <td>{{ $supplier->phone }}</td>
                                        <td>{{ $supplier->created_at }}</td>
                                        <td>{{ $supplier->updated_at }}</td>
                                        <td>
                                            <button class="btn btn-icon btn-success edit" data-toggle="modal"
                                                data-target="#viewSupplierModal"
                                                onClick="viewSupplier({{ $supplier->id }})"><i
                                                    class="icon feather icon-edit"></i></button>
                                            <form action="{{route('delete-supplier', $supplier->id)}}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-icon btn-danger delete" onclick="myFunction()"
                                                    type="submit"><i class="feather icon-trash-2"></i></button>
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
    <div class="modal fade" id="exampleModalLive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLiveLabel">Add Supplier</h5>
                </div>
                <form method="POST" action="{{route('store-supplier')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputName" class="col-form-label">Name</label>
                            <input type="text" class="form-control" id="inputName" name="name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress" class="col-form-label">Address</label>
                            <input type="text" class="form-control" id="inputAddress" name="address"
                                placeholder="Enter Address">
                        </div>
                        <div class="form-group">
                            <label for="inputPhone" class="col-form-label">Phone</label>
                            <input type="text" class="form-control" id="inputphone" name="phone"
                                placeholder="Enter Phone">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-window-close"> Close </i></button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"> Save </i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="viewSupplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Supplier</h5>
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
                            <input type="text" class="form-control" id="editAddress" name="address"
                                placeholder="Enter Address">
                        </div>
                        <div class="form-group">
                            <label for="editPhone" class="col-form-label">Phone</label>
                            <input type="text" class="form-control" id="editPhone" name="phone"
                                placeholder="Enter Phone">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close">
                            Close </i></button>
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
<script>
    $('#alt-pg-dt').DataTable();
</script>

<script>
    function viewSupplier(id) {
        $('#form-edit').attr('action', "{{ url('/update-supplier') }}/" + id)

        //View Modal
        $.ajax({
            type: "GET",
            url: "{{ url('/edit-supplier') }}/" + id,
            dataType: 'JSON',
            success: function (response) {

                $('#editName').val(response.supplier.name);
                $('#editAddress').val(response.supplier.alamat);
                $('#editPhone').val(response.supplier.phone);

            }
        });
    }

    function myFunction() {
        if (!confirm("Are You Sure to delete this"))
            event.preventDefault();
    }
</script>
@endpush
