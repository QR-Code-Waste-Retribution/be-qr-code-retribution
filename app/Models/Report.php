<?php

namespace App\Models;

use App\Utils\FileFormatPath;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Throwable;

class Report extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function showAll()
    {
        return $this->paginate(10);
    }

    public function storeReport($request)
    {
        try {
            $input = $request->validated();

            $file = $request->file('image');

            $fileFormatPath = new FileFormatPath('reports', $file);

            $this->create([
                'name' => $input['reports_name'],
                'price' => $input['price'],
                'notes' => $input['notes'],
                'payment_file' => $fileFormatPath->storeFile(),
                'reports_date' => $input['date'],
            ]);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPaymentFileUrlAttribute()
    {
        return 'storage/' . $this->payment_file;
    }
}
