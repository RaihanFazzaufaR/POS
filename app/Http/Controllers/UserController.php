<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';

        return view('user.index', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'activeMenu'=>$activeMenu]);
    }

    public function list(Request $request){
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')->with('level');

        return DataTables::of($users)
            ->addIndexColumn() //menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($user){
                $btn = '<a href="'.url('/user/' .$user->user_id). '" class="btn btn-primary btn-info btn-sm mr-1">Detail</a>';
                $btn .= '<a href="'.url('/user/' .$user->user_id. '/edit').'" class="btn btn-primary btn-warning btn-sm mr-1">Edit</a>';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/user/'.$user->user_id).'">'
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
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all();  //mengambil data level untuk ditampilkan di form
        $activeMenu = 'user'; //set menu yang aktif

        return view('user.create', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'level'=>$level, 'activeMenu'=>$activeMenu]);
    }

    public function store(Request $request){
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',   //username harus diisi minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'nama' => 'required|string|max:100',                            //nama harus diisi, maksimal 100 karakter
            'password' => 'required|min:5',                                 //password harus diisi
            'level_id' => 'required|integer'                                //level_id harus diisi dan berupa angka
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),                       //password dienkripsi sebelum disimpan
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    public function show($id){
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user';

        return view('user.show', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'user'=>$user, 'activeMenu'=>$activeMenu]);
    }

    public function edit(string $id){
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit user'
        ];

        $activeMenu = 'user';

        return view('user.edit', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'user'=>$user, 'level'=>$level, 'activeMenu'=>$activeMenu]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,'.$id.',user_id',   //username harus diisi minimal 3 karakter, dan bernilai unik di tabel m_user kolom username, kecuali untuk data dengan id yang sedang diedit
            'nama' => 'required|string|max:100',                            //nama harus diisi, maksimal 100 karakter
            'password' => 'nullable|min:5',                                 //password bisa diisi (minimal 5 karakter) dan bisa tidak diisi
            'level_id' => 'required|integer'                                //level_id harus diisi dan berupa angka
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,                       
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    public function destroy(string $id){
        $check = UserModel::find($id);
        if(!$check){
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try{
            UserModel::destroy($id);

            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        }catch(\Illuminate\Database\QueryException $e){
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih tabel lain yang terkait dengan data ini');
        }
    }


    // function index(){
    //     return view('user_form');
    // }

    // // Pertemuan 3
    // // Pertemuan 4
    // function index (){
    //     // $data = [
    //     //     'level_id' => 2,
    //     //     'username' => 'manager_tiga',
    //     //     'nama' => 'Manager 3',
    //     //     'password' => Hash::make('12345'),
    //     // ];
    //     // UserModel::create($data);


    //     // $data = [
    //     //     'nama' => 'Pelanggan Pertama'
    //     // ];
    //     // UserModel::where('username', 'customer-1')->update($data);


    //     // $user = UserModel::all();
       
        
    //     // $user = UserModel::find(1);


    //     // $user = UserModel::where('level_id', 1)->first();


    //     // $user = UserModel::firstWhere('level_id', 1);


    //     // $user = UserModel::findOr(20, ['username', 'nama'], function(){
    //     //     abort(404);
    //     // });


    //     // $user = UserModel::findOrFail(1);
       
        
    //     // $user = UserModel::where('username', 'manager9')->firstOrFail();


    //     // $user = UserModel::where('level_id', 2)->count();
    //     // dd($user);


    //     // $user = UserModel::firstOrCreate(
    //     //     [
    //     //         'username' => 'manager',
    //     //         'nama' => 'Manager'
    //     //     ]
    //     // );


    //     // $user = UserModel::firstOrCreate(
    //     //     [   
    //     //         'username' => 'manager22',
    //     //         'nama' => 'Manager Dua Dua',
    //     //         'password' => Hash::make('12345'),
    //     //         'level_id' => 2
    //     //     ]
    //     // );


    //     // $user = UserModel::firstOrNew(
    //     //     [
    //     //         'username' => 'manager',
    //     //         'nama' => 'Manager'
    //     //     ]
    //     // );


    //     // $user = UserModel::firstOrNew(
    //     //     [   
    //     //         'username' => 'manager33',
    //     //         'nama' => 'Manager Tiga Tiga',
    //     //         'password' => Hash::make('12345'),
    //     //         'level_id' => 2
    //     //     ]
    //     // );
    //     // $user->save();

    //     // return view('user', ['data' => $user]);
        

    //     // $user = UserModel::create(
    //     //     [
    //     //         'username' => 'manager55',
    //     //         'nama' => 'Manager Lima Lima',
    //     //         'password' => Hash::make('12345'),
    //     //         'level_id' => 2
    //     //     ]
    //     // );

    //     // $user->username = 'manager56';

    //     // $user->isDirty(); //true
    //     // $user->isDirty('username'); //true
    //     // $user->isDirty('nama'); //false
    //     // $user->isDirty(['nama', 'username']); //true

    //     // $user->isClean(); //false
    //     // $user->isClean('username'); //false
    //     // $user->isClean('nama'); //true
    //     // $user->isClean(['nama', 'username']); //false

    //     // $user->save();

    //     // $user->isDirty(); //false
    //     // $user->isClean(); //true
    //     // dd($user->isDirty());


    //     // $user = UserModel::create(
    //     //     [
    //     //         'username' => 'manager11',
    //     //         'nama' => 'Manager11',
    //     //         'password' => Hash::make('12345'),
    //     //         'level_id' => 2
    //     //     ]
    //     // );

    //     // $user->username = 'manager12';

    //     // $user->save();

    //     // $user->wasChanged(); //true
    //     // $user->wasChanged('username'); //true
    //     // $user->wasChanged(['username','level_id']); //true
    //     // $user->wasChanged('nama'); //false
    //     // dd($user->wasChanged(['nama','username'])); //true


    //     // $user = UserModel::all();


    //     $user = UserModel::with('level')->get();
    //     // dd($user);
    //     return view('user', ['data' => $user]);
    // }

    // public function tambah(){
    //     return view('user_tambah');
    // }

    // public function tambah_simpan(Request $request){
    //     UserModel::create([
    //         'username' => $request->username,
    //         'nama' => $request->nama,
    //         'password' => Hash::make($request->password),
    //         'level_id' => $request->level_id
    //     ]);
    //     return redirect('/user');
    // }

    // public function ubah($id){
    //     $user = UserModel::find($id);
    //     return view('user_ubah', ['data' => $user]);
    // }

    // public function ubah_simpan(Request $request, $id){
    //     $user = UserModel::find($id);

    //     $user->username = $request->username;
    //     $user->nama = $request->nama;
    //     $user->level_id = $request->level_id;

    //     $user->save();
    //     return redirect('/user');
    // }

    // public function hapus($id){
    //     $user = UserModel::find($id);
    //     $user->delete();

    //     return redirect('/user');
    // }


    // //Pertemuan 2
    // // function index($id, $name){
    // //     return view('user.user')
    // //     ->with('id', $id)
    // //     ->with('name', $name);
    // // }
}
