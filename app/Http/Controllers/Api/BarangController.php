<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index(){
        return BarangModel::all();
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required',
            'barang_kode' => 'required',
            'barang_nama' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $barang = BarangModel::create($request->all());

        if($barang){
            return response()->json([
                'success' => true,
                'user' => $barang,
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);

        // return response() -> json([$barang, 201]);
    }

    public function show(BarangModel $barang){
        return $barang;
    }

    public function update(Request $request, BarangModel $barang){
        $barang->update($request->all());
        return $barang;
    }

    public function destroy(BarangModel $barang){
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}
