<html>
<head>
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
  <style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5 class="text-danger">Rekap Kelas {{$tingkat->nama}}</h4>
		<h6>
      Tahun Ajaran : {{$tahun_ajaran}} <br>
      Semester : {{$semester}}
    </h5>
	</center>

  <table class="table" border="1" style="width: 100%;">
    <thead class="text-center">
      <tr>
        <th rowspan="2" style="width: 10px">NIK</th>
        <th rowspan="2">Nama</th>
        <th colspan="{{count($mapel)}}">Mata Pelajaran</th>
        <th rowspan="2">Total</th>
      </tr>
      <tr>
          @foreach ($mapel as $i_mapel)
          <th>
            {{$i_mapel->nama}}
          </th>
          @endforeach
      </tr>
    </thead>
    <tbody>
        @foreach ($siswa as $i_siswa)
        <tr>
            <td>{{$i_siswa->id}}</td>
            <td>
              {{$i_siswa->nama}}
            </td>

            @php
                $total_per_siswa = 0;
            @endphp

            @foreach ($nilai[$i_siswa->id] as $nilai_per_mapel)
            <td>{{$nilai_per_mapel}}</td>
              @php
                  $total_per_siswa += $nilai_per_mapel;
              @endphp
            @endforeach
            <td>{{$total_per_siswa/count($mapel)}}</td>
        </tr>
        @endforeach
    </tbody>
  </table>
</body>