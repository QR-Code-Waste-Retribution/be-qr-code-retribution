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
        return $this->with(['user:id,name,phoneNumber'])
            ->where('district_id', auth()->user()->district_id)
            ->paginate(10);
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
            $priceWithoutDecimals = str_replace(array(',', '.00'), '', $input['price']);
            $price = (int)$priceWithoutDecimals;

            $this->create([
                'name' => $input['reports_name'],
                'price' => $price,
                'notes' => $input['notes'],
                'payment_file' => $fileFormatPath->storeFile(),
                'reports_date' => $input['date'],
                'sts_no' => $input['sts_no'],
                'pemungut_id' => $input['pemungut_id'],
                'district_id' => auth()->user()->district_id,
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
