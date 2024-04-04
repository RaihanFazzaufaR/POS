@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary mx-4">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($penjualan)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        @else
        <table class="table table-bordered table-striped table-hover table-sm">
            <tr>
                <th>ID</th>
                <td>{{ $penjualan->penjualan_id }}</td>
            </tr>
            <tr>
                <th>Kasir</th>
                <td>{{ $penjualan->user->nama }}</td>
            </tr>
            <tr>
                <th>Kode Penjualan</th>
                <td>{{ $penjualan->penjualan_kode }}</td>
            </tr>
            <tr>
                <th>Pembeli</th>
                <td>{{ $penjualan->pembeli }}</td>
            </tr>
            <tr>
                <th>Tanggal Penjualan</th>
                <td>{{ $penjualan->penjualan_tanggal }}</td>
            </tr>
        </table>
        @endempty
    </div>
</div>
<div class="card card-outline card-pirmary mx-4">
    <div class="card-header">
        <h3 class="card-title">Detail Penjualan</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($penjualan_detail)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        @else
        <table class="table table-bordered table-striped table-hover table-sm">
            <tr class="text-center">
                <th>No</th>
                <th>Barang</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th></th>
            </tr>
            <?php $idx=1; ?>
            @foreach($penjualan_detail as $item)
            <tr>
                <td>{{ $idx++ }}</td>
                <td>{{ $item->barang->barang_nama }}</td>
                <td>Rp. {{ $item->harga }},00</td>
                <td>{{ $item->jumlah }}</td>
                <td>Rp. {{ $item->harga*$item->jumlah }},00</td>
            </tr>
            @endforeach
            <tr>
                <th class="text-center" colspan="4">TOTAL</th>
                <th>Rp. {{ $total }},00</th>
            </tr>
        </table>
        @endempty
        <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush
@push('js')
@endpush