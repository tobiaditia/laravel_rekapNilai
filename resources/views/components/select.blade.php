@if ($type == 'gender')

<div class="form-group">
    <label for="{{$field}}" class="col-sm-12 control-label">{{$label}}</label>
    <div class="col-sm-12">
        <select name="{{$field}}" id="{{$field}}" class="form-control select2 required">
            <option value="">Pilih Jenis Kelamin</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
    </div>
</div>

@elseif ($type == 'kelas')
@php
    $tingkat = DB::table('tingkat')->get();
@endphp
<div class="form-group">
    <label for="{{$field}}" class="col-sm-12 control-label">{{$label}}</label>
    <div class="col-sm-12">
        <select class="form-control select2" name="{{$field}}" id="{{$field}}">
            @foreach ($tingkat as $i_tingkat)
                <option value="{{$i_tingkat->id}}">{{$i_tingkat->nama}}</option>
            @endforeach
        </select>
    </div>
</div>

@elseif ($type == 'wali')
@php
    $guru = DB::table('guru')->get();
@endphp
<div class="form-group">
    <label for="guru_id" class="col-sm-12 control-label">{{$label}}</label>
    <div class="col-sm-12">
        <select class="form-control select2" name="guru_id" id="guru_id">
            <option value="0">Belum Ada</option>
            @foreach ($guru as $i_guru)
                <option value="{{$i_guru->id}}">{{$i_guru->nama}}</option>
            @endforeach
        </select>
    </div>
</div>

@elseif ($type == 'tahunAjaran')
@php
    $tahun_ajaran = array();
    for ($i=date('Y'); $i > 2015; $i--) { 
        $ii = $i + 1;
        $tahun_ajaran[] = $i."/".$ii;
    }
@endphp

<div class="form-group">
    <label for="tahunAjaran" class="col-sm-12 control-label">{{$label}}</label>
    <div class="col-sm-12">
        <select class="form-control select2" name="tahunAjaran" id="tahunAjaran">
            @foreach ($tahun_ajaran as $i_tahun_ajaran)
            <option value="{{$i_tahun_ajaran}}">{{$i_tahun_ajaran}}</option>
            @endforeach
        </select>
    </div>
</div>

@elseif ($type == 'semester')

<div class="form-group">
    <label for="semester" class="col-sm-12 control-label">{{$label}}</label>
    <div class="col-sm-12">
        <select class="form-control select2" name="semester" id="semester">
            @for ($i = 1; $i < 3; $i++)
            <option value="{{$i}}">{{$i}}</option>
            @endfor
        </select>
    </div>
</div>

@endif