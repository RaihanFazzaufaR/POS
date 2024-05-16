<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function fileUpload()
    {
        return view('file-upload');
    }

    public function prosesFileUpload(Request $request)
    {
        // dump($request->berkas);
        //dump($request->file('file'));
        // return "Pemrosesan file upload di sini";

        $request->validate([
            'berkas' => 'required|file|max:500'
        ]);
        $extFile = $request->berkas->getClientOriginalName();
        $namaFile = "web-" . time() . "." . $extFile;

        $path = $request->berkas->move('gambar', $namaFile);
        $path =str_replace("\\", "//", $path);
        echo "Variabel path berisi: $path <br>";


        $pathBaru = asset('gambar/'. $namaFile);
        echo "proses upload berhasil, file berada di " . $path;
        echo "<br>";
        echo "Tampilkan link: <a href='$pathBaru'>$pathBaru</a>";

        // $extFile = $request->berkas->getClientOriginalName();
        // $namaFile = "web-" . time() . "." . $extFile;
        // $path = $request->berkas->storeAs('public', $namaFile);

        // $pathBaru = asset('storage/'. $namaFile);
        // echo "proses upload berhasil, file berada di " . $path;
        // echo "<br>";
        // echo "Tampilkan link: <a href='$pathBaru'>$pathBaru</a>";


        // $namaFile = $request->berkas->getClientOriginalName();
        // $path = $request->berkas->storeAs('uploads', $namaFile);
        // echo "proses upload berhasil, file berada di " . $path;

        // $path = $request->berkas->store('uploads');

        // $path = $request->berkas->storeAs('uploads','berkas');
        // echo "proses upload berhasil, file berada di ". $path;

        // echo $request->berkas->getClientOriginalName()." lolos validasi";

        // if ($request->hasFile('berkas')) {
        //     echo "path(): " . $request->berkas->path();
        //     echo "<br>";
        //     echo "extension(): " . $request->berkas->extension();
        //     echo "<br>";
        //     echo "getClientOriginalExtension(): " . $request->berkas->getClientOriginalExtension();
        //     echo "<br>";
        //     echo "getMimeType(): " . $request->berkas->getMimeType();
        //     echo "<br>";
        //     echo "getClientOriginalName(): " . $request->berkas->getClientOriginalName();
        //     echo "<br>";
        //     echo "getSize(): " . $request->berkas->getSize();
        // } else {
        //     echo "Tidak ada file yang diupload";
        // }
    }
}
