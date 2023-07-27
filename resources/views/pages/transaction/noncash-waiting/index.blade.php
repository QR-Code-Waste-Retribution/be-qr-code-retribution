@extends('layout.app')

@section('css')
@endsection

@php
    $page_subtitle = true;
    $transaction_page_title = true;
@endphp

@section('page_title', 'DATA TRANSAKSI - Menunggu Konfirmasi - Pembayaran Non-Tunai')
@section('transaction_page_title', $payment_status ? strtoupper(str_replace('_', ' ', $payment_status)) : '')
@section('page_subtitle',
    'Periksa kesesuaian data dengan iuran yang sudah di dibayarkan oleh masyarakat. Jika pembayaran sudah sesuai, segera lakukan konfirmasi. ')
@section('breadcrumb_title', 'Data Transaksi')

@section('body')
    <div class="col-lg-12">
        @error('input_count')
        <div class="alert alert-danger text-center">
            <span class="fw-semibold"> &#9888; Anda belum memilih pembayaran!</span>
        </div>
        @enderror
        <div class="py-3 d-flex align-items-center" id="selected-item-confirmation-container">
            
            @if (session()->has('success'))
                <div class="alert alert-success">
                    <span>{{session('success')}}</span>
                </div>
            @endif

            <div class="w-100 bg-warning p-2 rounded text-center me-2">
                <span class=""><strong id="select-items-count">0</strong> Pembayaran telah dipilih</span>
            </div>
            <div>
                <button data-bs-toggle="modal" data-bs-target="#modal-confirmation-selected" class="btn btn-success">Konfirmasi</button>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-12">
               <div class="d-flex">
                    <div class="@if($payment_status == 'virtual_account') border-bottom border-3 border-success @else  @endif">
                        <a href="/transaction-noncash-waiting/{{$payment_via = 'virtual_account'}}/payment" class="text-bold fw-semibold @if($payment_status == 'virtual_account') link-dark @else link-secondary @endif">
                            Virtual Account
                        </a>
                    </div> 
                    <div class="px-3">
                        <h4 class="fw-light">|</h4>
                    </div>
                    <div class="@if($payment_status == 'qris') border-bottom border-3 border-success @else  @endif">
                        <a href="/transaction-noncash-waiting/{{$payment_via = 'qris'}}/payment" class="text-bold fw-semibold {{ $payment_status == 'qris' ? 'link-dark' : 'link-secondary' }}">
                            QRIS
                        </a>
                    </div> 
                    <div class="d-flex ms-auto align-items-center">
                        <div class="">
                            <div class="px-2">
                                <a href="/transaction-noncash-waiting/{{$payment_via = $payment_status}}/payment/excel/export" class="btn btn-sm btn-success"><i class="bi bi-file-earmark-excel-fill"></i> Export to Excel</a>
                            </div>
                        </div>
                        <div class="d-flex border border-1 border-secondary rounded">
                            <input type="text" class="form-control form-control-sm border-0" placeholder="Search..." id="searchInput">
                            <button class="btn btn-sm bg-transparent text-success border-0"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
               </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <table class="table fs-7 table-hover" id="noncash-table">
                <thead>
                    <tr>
                        <th>
                            <div class="d-flex align-items-center">
                                <input type="checkbox" class="form-check" id="select-all" onclick={checkAll()}>
                                <label for="select-all" class="fw-light ms-1">Pilih</label>
                            </div>
                        </th>
                        <th>Nama Wajib Retribusi</th>
                        <th>Kategori</th>
                        <th>Pembayar</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($transactions->count() > 0)
                        @foreach ($transactions as $item)
                            <tr class="searchable-item">
                                <td>
                                    <input type="checkbox" class="form-check select-items" onclick="check_item(event)" value="{{$item->id}}">
                                </td>
                                <td data-bs-toggle="modal" data-bs-target="#modal_detail_{{$item->id}}"><a class="fw-semibold link-dark" href="#"> {{$item->user->name}} </a></td>
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
                                <td>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal-confirmation-{{$item->id}}">Konfirmasi</button>
                                </td>
                            </tr>

                            {{-- Modal confirmation --}}
                                <div class="modal fade" id="modal-confirmation-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">
                                        <div class="p-4">
                                            <h5 class="fw-semibold text-secondary">Apakah Pembayaran {{$item->user->name}} senilai Rp.{{number_format($item->price, 0)}}  akan dikonfirmasi?</h5>
                                        </div>
                                            <img src="{{asset('/assets/img/konfirmasiii 1.png')}}" alt="">
                                        </div>
                                        <div class="modal-footer d-flex justify-content-center mt-2">
                                            <form method="POST" action="/transaction-noncash-waiting/{{$payment_via}}/payment/{{$item->id}}">
                                                @method('put')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success px-4" data-bs-dismiss="modal">Ya</button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-danger px-4" data-bs-dismiss="modal">Tidak</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                    
                            <!-- Modal Detail -->
                                <div class="modal fade" id="modal_detail_{{$item->id}}" tabindex="-1" aria-labelledby="modal_detail" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                        <div class="text-center p-4">
                                            <h5 class="fw-semibold">Detail</h5>
                                        </div>
                                        <div class="row py-1 text-center">
                                            <div class="col-md-4">
                                               Nama wajib Retribusi
                                            </div>
                                            <div class="col-md-1">
                                                :
                                            </div>
                                            <div class="col-md-7">
                                                {{$item->user->name}}
                                            </div>
                                        </div>
                                        <div class="row py-1 text-center">
                                            <div class="col-md-4">
                                               Kategori
                                            </div>
                                            <div class="col-md-1">
                                                :
                                            </div>
                                            <div class="col-md-7">
                                                @if ($item->invoice)
                                                @foreach ($item->invoice as $invoice)
                                                    @if ($invoice)
                                                        {{$invoice->category->first()->name}}
                                                    @endif
                                                @endforeach
                                            @endif
                                            </div>
                                        </div>
                                        <div class="row py-1 text-center">
                                            <div class="col-md-4">
                                                Kode Pesanan
                                            </div>
                                            <div class="col-md-1">
                                                :
                                            </div>
                                            <div class="col-md-7">
                                                {{$item->transaction_number}}
                                            </div>
                                        </div>
                                        <div class="row py-1 text-center">
                                            <div class="col-md-4">
                                                Metode Pembayaran
                                            </div>
                                            <div class="col-md-1">
                                                :
                                            </div>
                                            <div class="col-md-7">
                                                {{$payment_status ? strtoupper(str_replace('_', ' ', $payment_status)) : ''}}
                                            </div>
                                        </div>
                                        <div class="row py-1 text-center">
                                            <div class="col-md-4">
                                                Atas Nama
                                            </div>
                                            <div class="col-md-1">
                                                :
                                            </div>
                                            <div class="col-md-7">
                                                {{$item->user->name}}
                                            </div>
                                        </div>
                                        <div class="row py-1 text-center">
                                            <div class="col-md-4">
                                                Nominal
                                            </div>
                                            <div class="col-md-1">
                                                :
                                            </div>
                                            <div class="col-md-7">
                                                Rp.{{number_format($item->price, 0)}}
                                            </div>
                                        </div>
                                        <div class="row py-1 text-center">
                                            <div class="col-md-4">
                                                Tanggal Waktu
                                            </div>
                                            <div class="col-md-1">
                                                :
                                            </div>
                                            <div class="col-md-7">
                                                {{$item->date}}
                                            </div>
                                        </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-center">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>

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

                    {{-- Modal confirmation selected--}}
                    <div class="modal fade" id="modal-confirmation-selected" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                            <div class="p-4">
                                <h5 class="fw-semibold text-secondary">
                                     Konfirmasi seluruh pembayaran yang telah dipilih?
                                </h5>
                            </div>
                                <img src="{{asset('/assets/img/konfirmasiii 1.png')}}" alt="">
                            </div>
                            <div class="modal-footer d-flex justify-content-center mt-2">
                                <form method="POST" action="/transaction-noncash-waiting/{{$payment_status}}/payment/confirmation/selected">
                                    @csrf
                                    <input type="hidden" id="input-count" name="input_count">
                                    <button type="submit" class="btn btn-sm btn-success px-4" data-bs-dismiss="modal">Ya</button>
                                </form>
                                <button type="button" class="btn btn-sm btn-danger px-4" data-bs-dismiss="modal">Tidak</button>
                            </div>
                        </div>
                        </div>
                    </div>

                    {{-- Modal success confirmation--}}
                    @if (session()->has('success'))
                    <div class="modal fade show" id="modal-confirmation-selected" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                            <div class="p-4">
                                <h5 class="fw-semibold text-secondary">
                                     {{session('success')}}
                                </h5>
                            </div>
                                <img src="{{asset('/assets/img/success_confirmation_noncash.png')}}" alt="">
                            </div>
                        </div>
                        </div>
                    </div>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

<!-- Modal -->
  @if (session()->has('success'))
   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="p-4">
                    <h5 class="fw-semibold text-secondary mb-4">
                        {{session('success')}}
                    </h5>
                    <img src="{{asset('/assets/img/success-confirmation-noncash.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
   </div>
  @endif
@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<script>
  $(document).ready(function() {
    $('#myModal').modal('show');
  });
</script>

<script>
      const select_all = document.getElementById('select-all');
      const select_items = document.querySelectorAll('.select-items')
      const select_items_count = document.getElementById('select-items-count')
      const input_count = document.getElementById('input-count');
      const selected_item_area = document.getElementById('selected-item-confirmation-container')

      var checked_items = [];
      selected_item_area.classList.add('d-none');

      function update_items_count(){
          select_items_count.innerHTML = Object.keys(checked_items).length
          input_count.value = checked_items
          if(checked_items.length > 0){
              selected_item_area.classList.remove('d-none');
          }
          console.log(input_count)
      }

      function check_item(event) {
          if (event.target.checked === true) {
              checked_items.push(event.target.value);
              update_items_count();
              console.log(checked_items);
          } else {
              if (checked_items.indexOf(event.target.value) !== -1) {
                  console.log("not checked");
                  checked_items.splice(checked_items.indexOf(event.target.value), 1);
                  update_items_count();
                  console.log(checked_items);
              }
          }
      }

      function checkAll() {
          if (select_all.checked){
              select_items.forEach(e => {
                  e.checked = true
                  if (checked_items.indexOf(e.value) === -1) {
                      checked_items.push(e.value);
                  }
                  update_items_count()
              });
          }else{
              select_items.forEach(e => {
                  e.checked = false
                  checked_items.splice(checked_items.indexOf(e.value), 1)
                  update_items_count()
              });
          }
      }   

      function performSearch() {
          var input = document.getElementById("searchInput");
          var filter = input.value.toUpperCase();
          var items = document.getElementsByClassName("searchable-item");

          for (var i = 0; i < items.length; i++) {
          var item = items[i];
          var text = item.textContent || item.innerText;

          if (text.toUpperCase().indexOf(filter) > -1) {
              item.style.display = "";
          } else {
              item.style.display = "none";
          }
          }
      }

      document.getElementById("searchInput").addEventListener("keyup", performSearch);

      function exportTableToExcel(tableId, filename) {
      const table = document.getElementById(tableId);
      const rows = table.getElementsByTagName('tr');
      const data = [];

      // Start from index 1 to exclude the header row and stop before the last row
      for (let i = 0; i < rows.length; i++) {
          const row = rows[i];
          const rowData = [];
          const cells = row.getElementsByTagName('td');

          for (let j = 0; j < cells.length; j++) {
              rowData.push(cells[j].textContent);
          }

          data.push(rowData);
      }

      const ws = XLSX.utils.aoa_to_sheet(data);
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

      XLSX.writeFile(wb, filename);
  }

  function exportToExcel() {
    // Get the table by ID
    const table = document.getElementById("noncash-table");
    if (!table) {
      console.error("Table not found.");
      return;
    }

    // Convert the table data to an array
    const data = [];
    const headers = [];
    for (const row of table.rows) {
      const rowData = [];
      for (const cell of row.cells) {
        if (row.rowIndex === 0) {
          // Store the header cells separately
          headers.push(cell.textContent);
        } else {
          rowData.push(cell.textContent);
        }
      }
      if (row.rowIndex !== 0) {
        data.push(rowData);
      }
    }

    const workbook = XLSX.utils.book_new();
    const worksheet = XLSX.utils.aoa_to_sheet([headers, ...data]);

    // Add the worksheet to the workbook
    XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");

    // Convert the workbook to a binary Excel file and trigger the download
    const excelBuffer = XLSX.write(workbook, { bookType: "xlsx", type: "array" });
    saveAsExcelFile(excelBuffer, "exported_data.xlsx");
  }

  function saveAsExcelFile(buffer, fileName) {
    const data = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
    const url = URL.createObjectURL(data);
    const a = document.createElement("a");
    a.href = url;
    a.download = fileName;
    a.click();
    URL.revokeObjectURL(url);
  }

  </script>
@endsection
