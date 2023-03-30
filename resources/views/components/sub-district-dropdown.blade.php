<div class="col-{{ $col }}">
    <label for="" class="form-label fs-7 fw-medium">Pilih Kecamatan</label>
    <select class="form-select fs-7" aria-label="Default select example" name="sub_district">
        <option value="0" selected>Semua</option>
        @foreach ($sub_districts as $item)
            <option value="{{ $item->id }}"
                @if (request()->input('sub_district') == $item->id)
                    selected
                @endif
                >{{ $item->name }}</option>
        @endforeach
    </select>
</div>