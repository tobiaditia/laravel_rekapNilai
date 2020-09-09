<div class="modal fade" id="tambah-edit-modal" aria-hidden="true">
    <div class="modal-dialog 
        {{isset($size) ? $size : ""}}
        ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-judul">{{$titleModal}}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-12">

                            <input type="hidden" name="id" id="id">

                            @if ($type == 'nameOnly')

                            <x-input type="text" label="Nama" field="nama"/>

                            @elseif ($type == 'siswa')

                            <x-input type="text" label="Nama" field="nama"/>

                            <x-select type="kelas" label="Pilih Kelas" field="kelas_id"/>

                            <x-inputDate label="Tanggal Masuk" field="masuk"/>

                            @elseif ($type == 'tingkat')

                            <x-input type="text" label="Nama" field="nama"/>

                            <x-select type="wali" label="Pilih Wali" field="guru_id"/>

                            <x-multiCheckbox type="mapel" label="Pilih Mapel"/>

                            @elseif ($type == 'rekap')

                            @endif

                        </div>

                        <div class="col-sm-offset-2 col-sm-12">
                            <button type="submit" class="btn btn-primary btn-block" id="tombol-simpan"
                                value="create">Simpan
                            </button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>