<?php

namespace App\Utils;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Str;
use Imagick;

class FileFormatPath
{
    public $type;
    public $file;

    public function __construct($type = "qrcode", $file = null)
    {
        $this->type = $type;
        $this->file = $file;
    }

    public function getPath()
    {
        return "/" . $this->type . Carbon::now()->format('/Y/m/d/');
    }

    public function getFileName()
    {
        // path_name_file => /reports/2022/10/04/23423-zico-artonang.jpg

        $fullFileNameExtension = explode('.' . $this->file->getClientOriginalExtension(), $this->file->getClientOriginalName())[0];
        $fileName = $fullFileNameExtension;
        return substr(time(), 5) . '-' . Str::slug($fileName) . '.' . $this->file->getClientOriginalExtension();
    }

    public function getFullPathName()
    {
        return $this->getPath() . $this->getFileName();
    }

    public function storeFile()
    {
        try {
            $fileName = $this->getFileName();
            $folderPath = $this->getPath();

            Storage::putFileAs($folderPath, $this->file, $fileName);

            // $fullPathFile = storage_path("app/public". $folderPath . $fileName);

            // $this->convertPdfToImage($fullPathFile);

            return $folderPath . $fileName;
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function convertPdfToImage($pdfPath)
    {
        $pdf = new Pdf($pdfPath);

        $imagePath = public_path('/assets/reports/') . time() . '.jpg';
        $pdf->setPage(1)
            ->saveImage($imagePath);
    }
}
