<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\UserModel;
use App\Models\PenjualanDetailModel;
use App\Models\StokModel;
use App\Models\PenjualanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Daftar Transaksi Penjualan',
            'list' => ['Home', 'Transaksi Penjualan']
        ];

        $page = (object) [
            'title' => 'Daftar transakasi penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan';

        $user = UserModel::all();

        return view('penjualan.index', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'user'=>$user, 'activeMenu'=>$activeMenu]);
    }

    public function list(Request $request){
        $penjualans = PenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')->with('user');

        //Filter data user berdasarkan level_id
        if($request->user_id){
            $penjualans->where('user_id', $request->user_id);
        }

        return DataTables::of($penjualans)
            ->addIndexColumn() //menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($penjualan){
                $btn = '<a href="'.url('/penjualan/' .$penjualan->penjualan_id). '" class="btn btn-primary btn-info btn-sm mr-1">Detail</a>';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/penjualan/'.$penjualan->penjualan_id).'">'
                    .csrf_field()
                    .method_field('DELETE')
                    .'<button type="submit" class="btn btn-primary btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</button>'
                    .'</form>';
                return $btn;
            })
            ->rawColumns(['aksi'])  // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }  

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Transaksi Penjualan',
            'list' => ['Home', 'Transaksi Penjualan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah transaksi penjualan baru'
        ];
        
        $user = UserModel::all();
        $barang = BarangModel::with('kategori', 'stok')->get();

        $counter = (PenjualanModel::selectRaw("CAST(RIGHT(penjualan_kode, 3) AS UNSIGNED) AS counter")->orderBy('penjualan_kode', 'desc')->value('counter')) + 1;
        $penjualan_kode = 'PJ' . sprintf("%03d", $counter);

        //mengambil data level untuk ditampilkan di form
        $activeMenu = 'penjualan'; //set menu yang aktif

        return view('penjualan.create', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'user'=>$user, 'activeMenu'=>$activeMenu, 'penjualan_kode'=>$penjualan_kode, 'barang'=>$barang]);
    }

    public function store(Request $request){
        $request->validate([
            'user_id' => 'required|integer',
            'penjualan_kode' => 'required|string|min:3|unique:t_penjualan,penjualan_kode',
            'pembeli' => 'required|string|max:100',
            'barang_id.*' => 'required|integer',
            'jumlah.*' => 'required|integer',
            'harga.*' => 'required|integer',
        ]);

        $penjualan = PenjualanModel::create([
            'user_id' => $request->user_id,
            'penjualan_kode' => $request->penjualan_kode,
            'pembeli' => $request->pembeli,
            'penjualan_tanggal' => date('Y-m-d')
        ]);

        $barang_ids = $request->barang_id;
        $jumlahs = $request->jumlah;
        $hargas = $request->harga;

        foreach($barang_ids as $key => $barang_id){
            PenjualanDetailModel::create([
                'penjualan_id' => $penjualan->penjualan_id,
                'barang_id' => $barang_id,
                'jumlah' => $jumlahs[$key],
                'harga' => $hargas[$key]
            ]);

            $stok = (StokModel::where('barang_id', $barang_id)->value('stok_jumlah')) - $jumlahs[$key];
            $date = date('Y-m-d');
            StokModel::where('barang_id', $barang_id)->update(['stok_jumlah' => $stok, 'stok_tanggal' => $date]);
        }

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil disimpan');
    }

    public function show($id){
        $penjualan = PenjualanModel::find($id);
        $penjualan_detail = PenjualanDetailModel::where('penjualan_id', $id)->get();

        $breadcrumb = (object) [
            'title' => 'Detail Transaksi Penjualan',
            'list' => ['Home', 'Penjualan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Transaksi Penjualan'
        ];

        $activeMenu = 'penjualan';

        $total = 0;
        foreach($penjualan_detail as $detail){
            $total += $detail->jumlah * $detail->harga;
        }

        return view('penjualan.show', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'penjualan'=>$penjualan, 'penjualan_detail'=>$penjualan_detail,'total'=>$total ,'activeMenu'=>$activeMenu]);
    }

    public function destroy(string $id){
        $check = PenjualanModel::find($id);
        if(!$check){
            return redirect('/penjualan')->with('error', 'Data transaksi penjualan tidak ditemukan');
        }

        try{
            PenjualanModel::destroy($id);

            return redirect('/penjualan')->with('success', 'Data transaksi penjualan berhasil dihapus');
        }catch(\Illuminate\Database\QueryException $e){
            return redirect('/penjualan')->with('error', 'Data transaksi penjualan gagal dihapus karena masih ada tabel lain yang terkait dengan data ini');
        }
    }
}
