<?php

namespace App\Http\Controllers;

use App\Tingkat;
use Illuminate\Http\Request;

class TingkatController extends Controller
{

    public function index(Request $request)
    {
        $tingkat = Tingkat::all();
        if ($request->ajax()) 
        return datatables()->of($tingkat)
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
        return view('tingkat.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $mapel_id = (empty($request->mapel_id) ? "" : implode(",",$request->mapel_id));

        $post   =   Tingkat::updateOrCreate(['id' => $request->id],
                    [
                        'nama' => $request->nama,
                        'guru_id' => $request->guru_id,
                        'mapel_id' => $mapel_id,
                    ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $tingkat = Tingkat::find($id);

        return response()->json($tingkat);
    }

    public function destroy($id)
    {
        $tingkat = Tingkat::find($id)->delete();
     
        return response()->json($tingkat);
    }
}
