<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MahasiswaModel;

class apicontroller extends Controller
{
    //READ DATA
    public function get_all_mahasiswa(){
        return response()->json(MahasiswaModel::all(), 200);
    }

    //INSERT DATA
    public function insert_new_mahasiswa(Request $request){
        $insert_mahasiswa = new MahasiswaModel;
        $insert_mahasiswa->nama = $request->Nama_Mahasiswa;
        $insert_mahasiswa->gender = $request->Jenis_Kelamin;
        $insert_mahasiswa->ttl = $request->Tempat_Tanggal_Lahir;
        $insert_mahasiswa->prodi = $request->Program_Studi;
        $insert_mahasiswa->save();
        return response([
            'status' => 'SUCCESS',
            'message' => 'Data mahasiswa ditambahkan',
            'data' => $insert_mahasiswa
        ], 200);
    }

    //UPDATE DATA
    public function update_data_mahasiswa(Request $request, $id){
        $checktb = MahasiswaModel::firstWhere('NIM', $nim);
        if($checktb){
            $data_mahasiswa = MahasiswaModel::find($nim);
            $data_mahasiswa->nama = $request->Nama_Mahasiswa;
            $data_mahasiswa->gender = $request->Jenis_Kelamin;
            $data_mahasiswa->ttl = $request->Tempat_Tanggal_Lahir;
            $data_mahasiswa->prodi = $request->Program_Studi;
            $data_mahasiswa->save();
            return response([
                'status' => 'SUCCESS',
                'message' => 'Data mahasiswa diperbaharui',
                'update-data' => $data_mahasiswa
            ], 200);
        } else {
            return response([
                'status' => 'ERROR',
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }
    }

    //DELETE DATA
    public function delete_data_mahasiswa($nim){
        $checktb = MahasiswaModel::firstWhere('NIM', $nim);
        if($checktb){
            MahasiswaModel::destroy($nim);
            return response([
                'status' => 'SUCCESS',
                'message' => 'Data mahasiswa dihapus'
            ], 200);
        } else {
            return response([
                'status' => 'ERROR',
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }
    }
}