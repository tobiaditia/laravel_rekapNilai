<?php

namespace App\Http\Controllers;

use App\Imports\RekapPerKelasImport;
use App\Rekap;
use App\Mapel;
use App\Siswa;
use App\Tingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Session;
use Maatwebsite\Excel\Facades\Excel;

class RekapController extends Controller
{
    public function index()
    {
        $tingkat = Tingkat::orderby('nama', 'asc')->get();
        return view('rekap.index', compact('tingkat'));
    }

    public function store(Request $request)
    {
        $req_siswa = $request->siswa;
        $req_mapel = $request->mapel_id;
        $req_nilai = $request->nilai;
        $req_tingkat = $request->tingkat;
        $req_thunPel = $request->tahun_pelajaran;
        $req_semester = $request->semester;

        $jumlah_mapel = count($req_mapel);
        $jumlah_nilai = count($req_nilai);
        $jumlah_siswa = count($req_siswa);
        $per_siswa = $jumlah_nilai / $jumlah_siswa;

        $index = 0;
        foreach ($req_siswa as $siswa) {

            $arr_nilai_per_mapel = array();
            for ($i = $index ; $i < $per_siswa + $index; $i++) { 
                $arr_nilai_per_mapel[$req_mapel[$i%$jumlah_mapel]] = $req_nilai[$i];
            }

            $index = $index + $per_siswa;

            $arr_nilai_per_siswa[$siswa] = $arr_nilai_per_mapel;
        }

        // $id = $req_tingkat."_".str_replace('/','',$req_thunPel)."_".$req_semester;
        $nilai = json_encode($arr_nilai_per_siswa);
        // dd($nilai);

        // $post = Rekap::updateOrCreate(['id' => $request->id],
        Rekap::updateOrCreate(['id' => $request->id],
        [
            'id' => $request->id,
            'tingkat_id' => $req_tingkat,
            'nilai' => $nilai,
            'tahun_pelajaran' => $req_thunPel,
            'semester' => $req_semester,
            'user_id' => Auth::id(),
        ]); 

        return redirect('rekap');
    }

    public function edit($url_custom)
    {
        $check_data = Rekap::find($url_custom);

        $array_url = explode("_",$url_custom);

        if ($check_data == null) {
        
            $array_url = explode("_",$url_custom);
            $tahun_ajaran_awal = substr($array_url[1],0,4);
            $tahun_ajaran_akhir = substr($array_url[1],-4);

            $siswa = Siswa::where('kelas_id',$array_url[0])->get();
            $tingkat = Tingkat::find($array_url[0]);
            $arr_mapel_id = explode(',',$tingkat->mapel_id);
            $mapel = Mapel::whereIn('id',$arr_mapel_id);
            
            // $tingkat = Tingkat::select('id')->where('id', $array_url[0])->get();
            return view('rekap.edit', [
                'id' => $url_custom, 
                'mapel' => $mapel, 
                'siswa' => $siswa,
                'tingkat' => $tingkat,
                'tahun_ajaran' => $tahun_ajaran_awal."/".$tahun_ajaran_akhir,
                'semester' => $array_url[2]]);

        }else{
            $json_nilai = json_decode($check_data->nilai,TRUE);

            foreach($json_nilai as $key_siswa => $get_siswa){
                $id_mapel_lama = array_keys($get_siswa);
                $get_nilai_arr = array();
                foreach ($get_siswa as $get_mapel => $get_nilai) {
                    $get_nilai_arr[$get_mapel] = $get_nilai;
                }
                $nilai[$key_siswa] = $get_nilai_arr;
            }

            $arr_siswa = array_keys($json_nilai);

            $tingkat = Tingkat::find($check_data->tingkat_id);
            $arr_mapel_id = explode(',',$tingkat->mapel_id);
            $mapel = Mapel::whereIn('id',$arr_mapel_id)->get();
            $siswa = Siswa::where('kelas_id',$check_data->tingkat_id)->get();

            $siswa_lama = Siswa::whereIn('id',$arr_siswa);

            return view('rekap.edit', [
                'id_mapel_lama' => $id_mapel_lama,
                'id_siswa_lama' => $arr_siswa,
                'siswa_lama' => $siswa_lama,
                
                'id' => $url_custom, 
                'mapel' => $mapel, 
                'siswa' => $siswa,
                'tingkat' => $tingkat,
                'tahun_ajaran' => $check_data->tahun_pelajaran,
                'semester' => $check_data->semester,
                'nilai' => $nilai]);

        }
    }

    public function downloadPdfRekapKelas($url_custom)
    {
        $check_data = Rekap::find($url_custom);

        $json_nilai = json_decode($check_data->nilai,TRUE);

        foreach($json_nilai as $key_siswa => $get_siswa){
            $id_mapel_lama = array_keys($get_siswa);
            $get_nilai_arr = array();
            foreach ($get_siswa as $get_mapel => $get_nilai) {
                $get_nilai_arr[$get_mapel] = $get_nilai;
            }
            $nilai[$key_siswa] = $get_nilai_arr;
        }

        $arr_siswa = array_keys($json_nilai);

        $tingkat = Tingkat::find($check_data->tingkat_id);
        $mapel = Mapel::whereIn('id',$id_mapel_lama)->get();
        $siswa = Siswa::whereIn('id',$arr_siswa)->get();

        // dd($siswa);

        $pdf = PDF::loadview('rekap.rekap_pdf_kelas',[
            'id' => $url_custom, 
            'mapel' => $mapel, 
            'siswa' => $siswa,
            'tingkat' => $tingkat,
            'tahun_ajaran' => $check_data->tahun_pelajaran,
            'semester' => $check_data->semester,
            'nilai' => $nilai
        ]);
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML('<h1>Test</h1>');
    	// return $pdf->stream();
    	return $pdf->download('laporan-rekap');

    }

    // public function importExcel(Request $request)
    // {
    //     // dd($request);
    //     // validasi
	// 	$this->validate($request, [
	// 		'file' => 'required|mimes:csv,xls,xlsx'
	// 	]);
 
	// 	// menangkap file excel
	// 	$file = $request->file('file');
 
	// 	// membuat nama file unik
	// 	$nama_file = rand().$file->getClientOriginalName();
 
	// 	// upload ke folder file_siswa di dalam folder public
	// 	$file->move('file_import',$nama_file);
 
	// 	// import data
	// 	Excel::import(new RekapPerKelasImport, public_path('/file_import/'.$nama_file));
 
	// 	// notifikasi dengan session
	// 	Session::flash('sukses','Data Siswa Berhasil Diimport!');
 
	// 	// alihkan halaman kembali
	// 	return redirect('/rekap');
    // }

    public function update(Request $request, Rekap $rekap)
    {
        //
    }

    public function destroy(Rekap $rekap)
    {
        //
    }
}
