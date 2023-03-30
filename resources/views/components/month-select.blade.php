<div class="col-{{ $col }}">
    <label for="" class="form-label fs-7 fw-medium">Pilih Bulan</label>
    <select class="form-select fs-7" aria-label="Default select example" name="month">
        <option value="all" selected>Semua</option>
        @foreach ($months as $index => $value)
            <option value="{{ $index + 1 }}"
                @if (request()->input('month') == $index + 1)
                    selected
                @endif
            >{{ $value }}</option>
        @endforeach
    </select>
</div>
