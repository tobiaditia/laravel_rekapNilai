<?php

namespace App\Http\Controllers;

use App\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $siswa = Siswa::all();
        if ($request->ajax()) 
        return datatables()->of($siswa)
                ->addColumn('action', function($data){
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-info btn-sm edit-post"><i class="far fa-edit"></i> Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</button>';     
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);

        // return response()->json($guru);
        return view('siswa.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $post = Siswa::updateOrCreate(['id' => $request->id],
                [
                    'nama' => $request->nama,
                    'kelas_id' => $request->kelas_id,
                    'masuk' => $request->masuk,
                ]); 

        return response()->json($post);
    }

    public function show(Siswa $siswa)
    {
        return view('siswa.show',compact('siswa'));
    }

    public function edit($id)
    {
        $siswa = Siswa::find($id);

        return response()->json($siswa);
    }

    public function destroy($id)
    {
        $siswa = Siswa::find($id)->delete();
     
        return response()->json($siswa);
    }
}
