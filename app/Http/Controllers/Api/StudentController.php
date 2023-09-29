<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        $students = Student::latest()->paginate(5);

        return new StudentResource(true, 'List Data Mahasiswa', $students);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'npm' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'no_hp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $student = Student::create([
            'npm' => $request->npm,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'no_hp' => $request->no_hp,
        ]);

        return new StudentResource(true, 'Data Mahasiswa Berhasil Ditambahkan', $student);
    }

    public function show($id){
        $student = Student::find($id);

        return new StudentResource(true,'Detail Data Mahasiswa', $student);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'npm' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'no_hp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $student = Student::find($id);

        $student->update([
            'npm' => $request->npm,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'no_hp' => $request->no_hp,
        ]);

        return new StudentResource(true,'Data Mahasiswa Berhasil Diubah', $student);
    }

    public function destroy($id){
        $student = Student::find($id);

        $student->delete();

        return new StudentResource(true,'Data Mahasiswa Berhasil Dihapus', null);
    }
}
