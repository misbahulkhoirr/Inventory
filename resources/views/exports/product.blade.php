<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table id="fix-header" class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Nama Product</th>
                <th>Satuan</th>
                <th>Harga/Satuan</th>
                <th>Jumlah</th>
                @if($type == 'In')
                <th>Supplier</th>
                @endif
                <th>Gudang</th>
                <th>Create By</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $key => $data)
            <tr>
                <td>
                    {{$key+1}}.
                </td>
                <td>{{$data->created_at}}</td>
                <td>{{$data->product->product_name}}</td>
                <td>{{$data->product->satuan->satuan}}</td>
                <td>{{$data->product->price}}</td>
                <td>{{$data->jumlah}}</td>
                @if($type == 'In')
                <td>{{$data->supplier->name}}</td>
                @endif
                <td>{{$data->gudang->name}}</td>
                <td>{{$data->user->name}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>