@extends('layout.app')
@section('title','tingkat')

@section('content')
  @section('title_content','tingkat')
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
      <table id="tableTingkat" class="table table-striped table-bordered table-sm w-100">
        <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>Nama</th>
            <th>Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
    
  </div>
  <!-- /.card -->

  {{-- Load Components Modal --}}
  <x-modalAddEdit titleModal="Tambah Mapel" type="tingkat" size="modal-xl"/>

  <x-modalDelete titleModal="Hapus Mapel"/>
  
  <script>
  $(document).ready(function () {
    var datatable = $('#tableTingkat').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
            url : "{{route('tingkat.index')}}",
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
      $.get('tingkat/' + data_id + '/edit', function (data) {
          $('#modal-judul').html("Edit Mapel");
          $('#tombol-simpan').val("edit-post");
          $('#tambah-edit-modal').modal('show');
          
          $('#id').val(data.id);
          $('#nama').val(data.nama);
          $('#guru_id').val(data.guru_id).change();
          $('#guru_id').val(data.guru_id).change();

          var arr_ex = data.mapel_id.split(',');
          
          $('.ch').each(function(index, value) {
            var id = $(this).data('id').toString();
            if(jQuery.inArray(id, arr_ex ) > -1){
              $($(this)).prop('checked',true);
            }else{
              $($(this)).prop('checked',false);
            }
          });
      })
    });

    if ($("#form-tambah-edit").length > 0) {
      $("#form-tambah-edit").validate({
          submitHandler: function (form) {
              $('#tombol-simpan').html('Sending..');
              $.ajax({
                  data: $('#form-tambah-edit').serialize(), 
                  url: "{{ route('tingkat.store') }}", 
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
            url: "{{route('tingkat.index')}}/" + dataId, 
            type: 'delete',
            beforeSend: function () {
                $('#tombol-hapus').text('Hapus Data');
            },
            success: function (data) {
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