@extends('layout.app')
@section('title','Guru')

@section('content')
  @section('title_content','Guru')
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
      <table id="tableGuru" class="table table-striped table-bordered table-sm w-100">
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
  <x-modalAddEdit titleModal="Tambah Guru" type="nameOnly"/>

  <x-modalDelete titleModal="Hapus Guru"/>
  
    <script>
    $(document).ready(function () {
      var datatable = $('#tableGuru').DataTable({
          processing : true,
          serverSide : true,
          ajax : {
              url : "{{route('guru.index')}}",
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
          $('#id').val(''); //valuenya menjadi kosong
          $('#form-tambah-edit').trigger("reset"); //mereset semua input dll didalamnya
          $('#tambah-edit-modal').modal('show'); //modal tampil
      });

      $('body').on('click', '.edit-post', function () {
        var data_id = $(this).data('id');
        $.get('guru/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit Guru");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
            
            $('#id').val(data.id);
            $('#nama').val(data.nama);
        })
      });

      if ($("#form-tambah-edit").length > 0) {
        $("#form-tambah-edit").validate({
            submitHandler: function (form) {
                $('#tombol-simpan').html('Sending..');
                $.ajax({
                    data: $('#form-tambah-edit').serialize(), 
                    url: "{{ route('guru.store') }}", 
                    type: "POST", 
                    dataType: 'json', 
                    success: function (data) {  
                        $('#form-tambah-edit').trigger("reset"); 
                        $('#tambah-edit-modal').modal('hide'); 
                        $('#tombol-simpan').html('Simpan'); 
                        datatable.ajax.reload();
                        // iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                        //     title: 'Data Berhasil Disimpan',
                        //     message: '{{ Session('
                        //     success ')}}',
                        //     position: 'bottomRight'
                        // });
                    },
                    error: function (data) { //jika error tampilkan error pada console
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
              url: "{{route('guru.index')}}/" + dataId, //eksekusi ajax ke url ini
              type: 'delete',
              beforeSend: function () {
                  $('#tombol-hapus').text('Hapus Data'); //set text untuk tombol hapus
              },
              success: function (data) { //jika sukses
                  setTimeout(function () {
                      $('#konfirmasi-modal').modal('hide'); //sembunyikan konfirmasi modal
                      datatable.ajax.reload();
                  });
                  // iziToast.warning({ //tampilkan izitoast warning
                  //     title: 'Data Berhasil Dihapus',
                  //     message: '{{ Session('
                  //     delete ')}}',
                  //     position: 'bottomRight'
                  // });
              }
          })
      });
    })
    </script>
@endsection