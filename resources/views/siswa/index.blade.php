@extends('layout.app')
@section('title','siswa')

@section('content')
  @section('title_content','siswa')
  <div class="card">
    <div class="card-header">
        <h3 class="card-title">Simple Full Width Table</h3>

      <div class="card-tools">
          <div class="float-right">
            <a href="javascript:void(0)" class="btn btn-success btn-sm" id="add">Tambah</a>
          </div>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table class="table table-striped table-bordered table-sm w-100" id="tableSiswa">
        <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>Nama</th>
            <th>Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->

  {{-- Load Components Modal --}}
  <x-modalAddEdit titleModal="Tambah Siswa" type="siswa"/>

  <x-modalDelete titleModal="Hapus Siswa"/>

  <script>
    $(document).ready(function () {
      var datatable = $('#tableSiswa').DataTable({
          processing : true,
          serverSide : true,
          ajax : {
              url : "{{route('siswa.index')}}",
              type : "GET"
          },
          columns : [
              { data : 'id', name : 'id' },
              { data : 'nama', name : 'nama' },
              { data : 'action', name : 'action' },
          ],
          order : [[0, "asc"]]
      });

      $('#add').click(function () {
          $('#id').val(''); 
          $('#form-tambah-edit').trigger("reset"); 
          $('#tambah-edit-modal').modal('show'); 
      });

      $('body').on('click', '.edit-post', function () {
        var data_id = $(this).data('id');
        $.get('siswa/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit Siswa");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');

            $('#id').val(data.id);
            $('#nama').val(data.nama);
            $('#kelas_id').val(data.kelas_id).change();
            $('#masuk').val(data.masuk);
        })
      });

      if ($("#form-tambah-edit").length > 0) {
        $("#form-tambah-edit").validate({
            submitHandler: function (form) {
                $('#tombol-simpan').html('Sending..');
                $.ajax({
                    data: $('#form-tambah-edit').serialize(), 
                    url: "{{ route('siswa.store') }}", 
                    type: "POST", 
                    dataType: 'json', 
                    success: function (data) {  
                        $('#form-tambah-edit').trigger("reset"); 
                        $('#tambah-edit-modal').modal('hide'); 
                        $('#tombol-simpan').html('Simpan'); 
                        datatable.ajax.reload();
                    },
                    error: function (data) { 
                        console.log('Error:', data);
                        $('#tombol-simpan').html('Simpan');
                    }
                });
            }
        })
      }

      $(document).on('click', '.delete', function () {
          dataId = $(this).attr('id');
          $('#konfirmasi-modal').modal('show');
      });

      $('#tombol-hapus').click(function () {
          $.ajax({
              url: "{{route('siswa.index')}}/" + dataId, 
              type: 'delete',
              beforeSend: function () {
                  $('#tombol-hapus').text('Hapus Data'); 
              },
              success: function (data) { //jika sukses
                  setTimeout(function () {
                      $('#konfirmasi-modal').modal('hide'); 
                      datatable.ajax.reload();
                  });
              }
          })
      });
    })
    </script>
@endsection