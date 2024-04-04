<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StorePostRequest;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar kategori yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kategori';

        return view('kategori.index', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'activeMenu'=>$activeMenu]);
    }

    public function list(Request $request){
        $kategoris = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        return DataTables::of($kategoris)
            ->addIndexColumn() //menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($kategori){
                $btn = '<a href="'.url('/kategori/' .$kategori->kategori_id). '" class="btn btn-primary btn-info btn-sm mr-1">Detail</a>';
                $btn .= '<a href="'.url('/kategori/' .$kategori->kategori_id. '/edit').'" class="btn btn-primary btn-warning btn-sm mr-1">Edit</a>';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/kategori/'.$kategori->kategori_id).'">'
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
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah kategori baru'
        ];

        $activeMenu = 'kategori'; //set menu yang aktif

        return view('kategori.create', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'activeMenu'=>$activeMenu]);
    }

    public function store(Request $request){
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100'
        ]);

        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    public function show($id){
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.show', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'kategori'=>$kategori, 'activeMenu'=>$activeMenu]);
    }

    public function edit(string $id){
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.edit', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'kategori' => $kategori, 'activeMenu'=>$activeMenu]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'kategori_kode' => 'required|string|min:3',
            'kategori_nama' => 'required|string|max:100'
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }

    public function destroy(string $id){
        $check = KategoriModel::find($id);
        if(!$check){
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try{
            KategoriModel::destroy($id);

            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        }catch(\Illuminate\Database\QueryException $e){
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih tabel lain yang terkait dengan data ini');
        }
    }



    //Show the form to create a new post
    // public function create(): View {
    //     return view('kategori.create');
    // }

    // //Store a new post
    // public function store(StorePostRequest $request): RedirectResponse {

    //     // The incoming request is valid...

    //     // Retrieve the validated input data...
    //     $validated = $request->validated();

    //     //retrieve the validated input data
    //     $validated = $request->safe()->only(['kategori_kode', 'kategori_nama']);
    //     $validated = $request->safe()->except(['kategori_kode', 'kategori_nama']);

    //     //Store the post...
    //     return redirect('/kategori');
    // }


    // public function index(KategoriDataTable $dataTable)
    // {
    //     return $dataTable->render('kategori.index');
    
        // $data=[
        //     'kategori_kode' => 'SNK',
        //     'kategori_nama' => 'Snack',
        //     'created_at' => now()
        // ];
        // DB::table('m_kategori')->insert($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'Camilan']);
        // return 'Update data berhasil. Jumlah data yang diupdate: '.$row." baris"; 

        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
        // return 'Delete data berhasil. Jumlah data yang dihapus: '.$row." baris";

        // $data = DB::table('m_kategori')->get();
        // return view('kategori', ['data' => $data]);
    // }

    // public function create()
    // {
    //     return view('kategori.create');
    // }

    // public function store(Request $request)
    // {
    //     KategoriModel::create([
    //         'kategori_kode' => $request->kodeKategori,
    //         'kategori_nama' => $request->namaKategori,
    //     ]);
    //     return redirect('/kategori');
    // }

    // public function edit($id)
    // {
    //     $data = KategoriModel::find($id);
    //     return view('kategori.edit', ['data' => $data]);
    // }

    // public function update(Request $request, $id)
    // {
    //     KategoriModel::where('kategori_id', $id)->update([
    //         'kategori_kode' => $request->kodeKategori,
    //         'kategori_nama' => $request->namaKategori,
    //     ]);
    //     return redirect('/kategori');
    // }

    // public function destroy($id)
    // {
    //     KategoriModel::destroy($id);
    //     return redirect('/kategori');
    // }
}
