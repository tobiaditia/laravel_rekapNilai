@extends('layout.app')
@section('title','Rekap')

@section('content')
  @section('title_content','Rekap')
  <div class="card">
    @php
      $not_same = false;
      $new_data = true;
      if (!empty($nilai)) {
        
        $new_data = false;

        $a_mapel_now = array();

        foreach ($mapel as $i_mapel) $a_mapel_now[] = $i_mapel->id;

        if ($id_mapel_lama !== $a_mapel_now) {
          $not_same = true;
          $nilai = null;
        }
      }
    @endphp

    @if ($not_same)
    <div class="tidakcocok alert alert-danger d-flex justify-content-between">
      <div>
        Data lama tidak cocok dengan <b>format </b>ini.
      </div>
      <div>
        <a href="#" class="link btn btn-dark btn-sm">Unduh Data Lama</a>
      </div>
    </div>
    @elseif ($new_data)
    <div class="alert alert-primary d-flex justify-content-between">
      <div>
        <b>Belum ada data di rekap ini. Silahkan isikan data</b>
      </div>
    </div>
    @endif

    <form action="/rekap" method="post">
      @csrf
      <input type="hidden" name="id" value="{{$id}}">
      <input type="hidden" name="tahun_pelajaran" value="{{$tahun_ajaran}}">
      <input type="hidden" name="semester" value="{{$semester}}">
      <input type="hidden" name="tingkat" value="{{$tingkat->id}}">
      <div class="card-header">
          <h3 class="card-title text-bold">Rekap Kelas {{$tingkat->nama}}</h3>

          <div class="card-tools">
            <div class="float-right">
              <table border="0" class="text-bold">
                <tr>
                  <td>Tahun Ajaran</td>
                  <td> : {{$tahun_ajaran}}</td>
                </tr>
                <tr>
                  <td>Semester</td>
                  <td> : {{$semester}}</td>
                </tr>
              </table>
              
            </div>
        </div>
      </div>
      <div class="card-body">
        <table class="table" id="datatable">
          <thead class="text-center">
            <tr>
              <th rowspan="2" style="width: 10px">NIK</th>
              <th rowspan="2">Nama</th>
              <th colspan="7">Mata Pelajaran</th>
            </tr>
            <tr>
                @foreach ($mapel as $i_mapel)
                <th>
                  <input type="hidden" name="mapel_id[]" value="{{$i_mapel->id}}">
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
                    <input type="hidden" name="siswa[]" value="{{$i_siswa->id}}">
                    {{$i_siswa->nama}}
                  </td>

                  @if (!$new_data && !$not_same)
                    @if (in_array($i_siswa->id,$id_siswa_lama))
                      @foreach ($nilai[$i_siswa->id] as $nilai_per_mapel)
                      <td><input type="text" class="form-control" name="nilai[]" value="{{$nilai_per_mapel}}"></td>
                      @endforeach
                    @else
                      @for ($y = 0; $y < $mapel->count(); $y++)
                      <td><input type="text" class="form-control" name="nilai[]"></td>
                      @endfor
                    @endif
                  @else
                    @for ($y = 0; $y < $mapel->count(); $y++)
                    <td><input type="text" class="form-control" name="nilai[]"></td>
                    @endfor
                  @endif
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer">
          <div class="float-right">
              <a href="/rekap/{{$id}}/download-pdf-rekap-kelas" type="button" class="btn btn-secondary">
                  <i class="fas fa-file-export mr-1"></i> Export
              </a>
              <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save mr-1"></i> Save
              </button>
              <button type="button" class="btn btn-warning">
                  <i class="fas fa-lock mr-1"></i> Kunci
              </button>
          </div>
      </div>
    </form>
  </div>
  <!-- /.card -->
  <script>
    $(document).ready(function () {
      var buttonCommon = {
        exportOptions: {
          format: {
            body: function ( data, row, column, node ) {
              return node.firstChild.tagName === "INPUT" ?
                node.firstElementChild.value :
                // data;
                node.lastChild.textContent.trim();

              }
          }
        }
      };

      $('#datatable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            $.extend( true, {}, buttonCommon, {
                extend: 'copyHtml5'
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'excelHtml5'
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'pdfHtml5'
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'csvHtml5',
            } )
        ],
        initComplete: function () {
            var btns = $('.dt-button');
            btns.addClass('btn btn-success btn-sm');
            btns.removeClass('dt-button');

            $('.dt-buttons').addClass('mb-2');
        },
        "searching": false,
        "paging":   false,
        "ordering": false,
        "info":     false
      });
    })
    </script>
@endsection