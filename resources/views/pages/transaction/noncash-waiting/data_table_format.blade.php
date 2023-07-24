<table border="1" cellspacing="0" cellpadding="5" class="table fs-7 table-hover" id="noncash-table">
    <thead> 
        <tr>
            <th>Nama Wajib Retribusi</th>
            <th>Kategori</th>
            <th>Pembayar</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @if($transactions->count() > 0)
            @foreach ($transactions as $item)
                <tr class="searchable-item">
                    <td>{{$item->pemungut->name}}</td>
                    <td>
                        @if ($item->invoice)
                            @foreach ($item->invoice as $invoice)
                                @if ($invoice)
                                    {{$invoice->category->first()->name}}
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td>{{$item->user->name}}</td>
                    <td>{{'Rp '.number_format($item->price, 0)}}</td>
                </tr>
            @endforeach

        @else 
            <tr>
                <td colspan="6">
                    <div class="text-center text-secondary py-2">
                        <h4>Data tidak ditemukan</h4>
                    </div>
                </td>
            </tr>
        @endif

    </tbody>
</table>