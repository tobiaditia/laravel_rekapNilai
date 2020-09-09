<?php

namespace App\Http\Controllers;

use App\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{

    public function index(Request $request)
    {
        $guru = Guru::all();
        if ($request->ajax()) 
        return datatables()->of($guru)
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
        return view('guru.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $post   =   Guru::updateOrCreate(['id' => $request->id],
                    [
                        'nama' => $request->nama,
                    ]); 

        return response()->json($post);
    }

    public function show(Guru $guru)
    {
        return view('guru.show',compact('guru'));
    }

    public function edit($id)
    {
        $guru = Guru::find($id);

        return response()->json($guru);
    }

    public function destroy($id)
    {
        $guru = Guru::find($id)->delete();
     
        return response()->json($guru);
    }
}
