<?php

namespace App\Http\Controllers;

use App\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index(Request $request)
    {
        $mapel = Mapel::all();
        if ($request->ajax()) 
        return datatables()->of($mapel)
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
        return view('mapel.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $post   =   Mapel::updateOrCreate(['id' => $request->id],
                    [
                        'nama' => $request->nama,
                    ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $mapel = Mapel::find($id);

        return response()->json($mapel);
    }

    public function destroy($id)
    {
        $mapel = Mapel::find($id)->delete();
     
        return response()->json($mapel);
    }
}
