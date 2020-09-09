<div class="form-group">
    <label for="{{$field}}" class="col-sm-12 control-label">{{$label}}</label>
    <div class="col-sm-12">
        <input type="{{$type}}" class="form-control" id="{{$field}}" name="{{$field}}"

            @isset($value)
            value="{{old('$field') ? old('$field') : $value}}"
            @else  
            value="{{old('$field')}}"
            @endisset

        required>
    </div>
</div>