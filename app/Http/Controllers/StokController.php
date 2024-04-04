<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;
use App\Models\StokModel;
use App\Models\UserModel;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar stok yang terdaftar dalam sistem'
        ];

        $barang = BarangModel::all();
        $user = UserModel::all();

        $activeMenu = 'stok';

        return view('stok.index', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'barang' => $barang, 'user' => $user, 'activeMenu'=>$activeMenu]);
    }

    public function list(Request $request){
        $stoks = StokModel::select('stok_id','barang_id','user_id', 'stok_tanggal', 'stok_jumlah')->with('barang', 'user');

        if($request->barang_id){
            $stoks->where('barang_id', $request->barang_id);
        }

        if($request->user_id){
            $stoks->where('user_id', $request->user_id);
        }

        return DataTables::of($stoks)
            ->addIndexColumn() //menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($stok){
                $btn = '<a href="'.url('/stok/' .$stok->stok_id). '" class="btn btn-primary btn-info btn-sm mr-1">Detail</a>';
                $btn .= '<a href="'.url('/stok/' .$stok->barang_id. '/edit').'" class="btn btn-primary btn-warning btn-sm mr-1">Edit</a>';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/stok/'.$stok->stok_id).'">'
                    .csrf_field()
                    .method_field('DELETE')
                    .'<button type="submit" class="btn btn-primary btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</button>'
                    .'</form>';
                return $btn;
            })
            ->rawColumns(['aksi'])  // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function show($id){
        $stok = StokModel::with('barang', 'user')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Stok',
            'list' => ['Home', 'Stok', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail stok'
        ];

        $activeMenu = 'stok';

        return view('stok.show', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'stok'=>$stok, 'activeMenu'=>$activeMenu]);
    }

    public function edit(string $id){
        $stok = StokModel::find($id);
        $barang = BarangModel::all();
        $user = UserModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit stok'
        ];

        $activeMenu = 'stok';

        return view('stok.edit', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'barang'=>$barang, 'user'=>$user,'stok'=>$stok, 'activeMenu'=>$activeMenu]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'stok_jumlah' => 'required|integer',
            'user_id' => 'required|integer|exists:m_user,user_id'
        ]);

        StokModel::find($id)->update([
            'stok_tanggal' => date('Y-m-d'),
            'stok_jumlah' => $request->stok_jumlah,
            'user_id' => $request->user_id
        ]);

        return redirect('/stok')->with('success', 'Data stok berhasil diubah');
    }

    public function destroy(string $id){
        $check = StokModel::find($id);
        if(!$check){
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        try{
            $stok_id = StokModel::where('stok_id', $id)->value('barang_id');
            StokModel::destroy($id);
            BarangModel::destroy($stok_id);

            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        }catch(\Illuminate\Database\QueryException $e){
            return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih tabel lain yang terkait dengan data ini');
        }
    }
}
