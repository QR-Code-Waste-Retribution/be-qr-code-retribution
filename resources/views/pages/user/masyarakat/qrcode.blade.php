<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>How to Generate QR Code in Laravel 9</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

    <div class="container-fluid mt-4">
        <div class="d-flex flex-wrap gap-3">
            @foreach ($users as $item)
                <div class="item text-wrap d-flex justify-content-center flex-column align-items-center"
                    style="width: 220px">
                    {!! QrCode::size(150)->generate($item->uuid) !!}
                    <p style="font-size: 16px" class="text-center fw-bold mt-2 mb-0">{{ $item->name }}</p>
                </div>
            @endforeach
        </div>
    </div>
</body>

</html>
