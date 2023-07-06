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
        return $this->with(['user:id,name,phoneNumber'])->paginate(10);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'pemungut_id', 'id');
    }

    public function storeReport($request)
    {
        try {
            $input = $request->validated();

            $file = $request->file('image');

            $fileFormatPath = new FileFormatPath('reports', $file);

            $report = $this->create([
                'name' => $input['reports_name'],
                'price' => $input['price'],
                'notes' => $input['notes'],
                'payment_file' => $fileFormatPath->storeFile(),
                'reports_date' => $input['date'],
                'sts_no' => $input['sts_no'],
                'pemungut_id' => $input['pemungut_id'],
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
