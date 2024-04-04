@extends('layouts.template')

@section('content')
<form method="POST" action="{{ url('penjualan') }}">
    <div class="card card-outline card-primary mx-5">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @csrf
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">User</label>
                <div class="col-11">
                    <select class="form-control" id="user_id" name="user_id" required>
                        <option value="">- Pilih User -</option>
                        @foreach($user as $item)
                        <option value="{{ $item->user_id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Penjualan Kode</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode" value="{{ $penjualan_kode }}" required readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Pembeli</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="pembeli" name="pembeli" value="{{ old('pembeli') }}" required>
                    @error('pembeli')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">
                    Total
                </label>
                <div class="col-3">
                    <input type="number" class="form-control" id="total" name="total" value="0" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="card mx-5">
        <div class="card-header">
            <h3 class="card-title">Daftar Barang yang dipilih</h3>
            <div class="card-tools">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#tambahBarang">
                    Tambah barang
                </button>

                <!-- Modal -->
                <div class="modal fade" id="tambahBarang" tabindex="-1" aria-labelledby="tambahBarangLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahBarangLabel">Daftar barang yang tersedia</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered table-striped table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center">Kode Barang</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Stok</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $idx = 1; ?>
                                        @foreach ($barang as $dt)
                                        <tr>
                                            <td class="text-center">{{ $idx++ }}</td>
                                            <td class="text-center">{{ $dt->kategori->kategori_nama }}</td>
                                            <td class="text-center">{{ $dt->barang_kode }}</td>
                                            <td class="text-center">{{ $dt->barang_nama }}</td>
                                            <td class="text-center">{{ $dt->stok->stok_jumlah }}</td>
                                            <td class="text-center">{{ $dt->harga_jual }}</td>
                                            <td class="text-center">
                                                <!-- <button type="button" data-toggle="modal" data-target="#stokModal{{$dt->barang_id}}" class="btn btn-primary">Pilih</button> -->
                                                <div class="btn btn-primary" onclick="tambahKeranjang({{ $dt->barang_id }}, '{{ $dt->barang_nama }}', {{ $dt->harga_jual }}, 1, {{ $dt->stok->stok_jumlah }})">Pilih</div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Barang</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="table_barang">
                </tbody>
            </table>
        </div>
        
    </div>

    <div class="card mx-5">
        <div class="card-body">
            <div class="col-11">
                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                <a class="btn btn-default ml-1" href="{{ url('penjualan') }}">Kembali</a>
            </div>
        </div>
    </div>
</form>
@endsection
@push('css')
@endpush
@push('js')
<script>
    let tableBarang = document.getElementById("table_barang");
    let items = [];

    function templateBaris(barangId, barangNama, harga, jumlah, stok) {
        return `
            <td class="text-center">${tableBarang.rows.length + 1}</td>
            <td class="text-center">${barangNama}</td>
            <td class="text-center">${harga}</td>
            <td class="text-center">
                <span>${jumlah}</span> 
                <i class="fa-solid fa-plus-minus mx-2" style="color: #B197FC; cursor: pointer;" data-toggle="modal" data-target="#stokModal${barangId}"></i>
            </td>
            <td class="text-center">
                <button class="btn btn-danger" onclick="hapusBarang(${barangId})">Hapus</button>
            </td>
            <input type="hidden" id="barang_id" name="barang_id[]" value="${barangId}">
            <input type="hidden" id="harga" name="harga[]" value="${harga}">
            <input type="hidden" id="jumlah" name="jumlah[]" value="${jumlah}">

            <!-- modal -->
            <div class="modal" tabindex="-1" id="stokModal${barangId}">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">${barangNama}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="jumlahBaru">Jumlah</label>
                            <input type="number" id="jumlahBaru" name="jumlahBaru" class="form-control" value="1" min="1" max="${stok}" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="ubahJumlahBarang(${barangId})" data-dismiss="modal">Ubah Jumlah</button>
                        </div>
                    </div>
                </div>
            </div> 
        `;
    }

    function tambahKeranjang(barangId, barangNama, harga, jumlah, stok) {
        if (items.includes(barangId)) {
            let inputJumlah = tableBarang.querySelectorAll("input[name='jumlah[]']");
            let index = items.indexOf(barangId);
            let tr = tableBarang.querySelectorAll('tr')[index];
            let value = parseInt(inputJumlah[index].value) + 1;

            inputJumlah[index].value = value;
            let td = tr.querySelectorAll('td')[3]
            td.querySelector('span').innerText = value;
            updateTotal();
            return;
        }

        items.push(barangId);

        let barisBaru = document.createElement("tr");
        barisBaru.innerHTML = templateBaris(barangId, barangNama, harga, jumlah, stok);

        tableBarang.appendChild(barisBaru);
        updateTotal();
    }

    function hapusBarang(barangId) {
        let index = items.indexOf(barangId);
        items.splice(index, 1);

        let tr = tableBarang.querySelectorAll('tr')[index];
        tr.remove();

        let trs = tableBarang.querySelectorAll('tr');
        trs.forEach((tr, idx) => {
            tr.querySelectorAll('td')[0].innerText = idx + 1;
        });
        updateTotal();
    }

    function ubahJumlahBarang(barangId) {
        let index = items.indexOf(barangId);
        let tr = tableBarang.querySelectorAll('tr')[index];

        let inputJumlah = tr.querySelector("input[name='jumlah[]']");
        let inputJumlahBaru = tr.querySelector("input[name='jumlahBaru']");

        inputJumlah.value = inputJumlahBaru.value;
        let td = tr.querySelectorAll('td')[3];
        td.querySelector('span').innerText = inputJumlahBaru.value;
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        let harga = tableBarang.querySelectorAll("input[name='harga[]']");
        let jumlah = tableBarang.querySelectorAll("input[name='jumlah[]']");

        harga.forEach((item, index) => {
            total += parseInt(item.value) * parseInt(jumlah[index].value);
        });

        document.getElementById("total").value = total;
    }
</script>
@endpush