@extends('layout.app')
@section('title','Rekap')

@section('content')
  @section('title_content','Rekap')
  {{-- <button class="btn btn-sm btn-success">Import</button> --}}

    {{-- @if ($errors->has('file'))
		<span class="invalid-feedback" role="alert">
			<strong>{{ $errors->first('file') }}</strong>
		</span>
		@endif --}}
 
		{{-- notifikasi sukses --}}
		{{-- @if ($sukses = Session::get('sukses'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button> 
			<strong>{{ $sukses }}</strong>
		</div>
		@endif --}}
 
		{{-- <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#importExcel">
			IMPORT EXCEL
		</button>
  --}}
		<!-- Import Excel -->
		{{-- <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form action="/rekap/import-excel" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
						</div>
						<div class="modal-body">
 
							<label>Pilih file excel</label>
							<div class="form-group">
								<input type="file" name="file" required="required">
							</div>
 
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Import</button>
						</div>
					</div>
				</form>
			</div>
		</div> --}}

  <div class="card">
    <div class="card-header">
      <div class="d-flex align-items-center">
        <p class="text-bold mr-3">Pilih : </p>
        <x-select type="tahunAjaran" label="Tahun Ajaran"/>
        <x-select type="semester" label="Semester"/>
      </div>
      
    </div>
    <div class="card-body">
      <table id="tableRekap" class="table table-striped table-bordered table-sm w-100">
        <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>Kelas</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($tingkat as $i_tingkat)
          <tr>
              <td>#</td>
              <td>{{$i_tingkat->nama}}</td>
              <td>
                <a href="" data-idlink="{{$i_tingkat->id}}" class="link btn btn-sm btn-info">
                  <i class="fas fa-cogs"></i>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </div>
  <!-- /.card -->

  <script>
    $(document).ready(function () {
      var urlRouteRekap = "{{url('tingkat.index')}}";
      var tahunAjaran = $('#tahunAjaran').val().replace("/", '');
      var semester = $('#semester').val();

      makeUrl(tahunAjaran,semester);

      var yearNow = new Date().getFullYear();

      $('#tahunAjaran').on('change', function() {
        tahunAjaran = $('#tahunAjaran').val().replace("/", '');
        semester = $('#semester').val();
        makeUrl(tahunAjaran,semester);
      });

      $('#semester').on('change', function() {
        tahunAjaran = $('#tahunAjaran').val().replace("/", '');
        semester = $('#semester').val();
        makeUrl(tahunAjaran,semester);
      });

      function makeUrl(tahunAjaran, semester) {
        $('.link').each(function(){
          var id = $(this).data('idlink').toString();
          $(this).attr("href", "{{ url('rekap') }}/"+id+"_"+tahunAjaran+"_"+semester+"/edit")
        });
      }

    })
  </script>
@endsection

