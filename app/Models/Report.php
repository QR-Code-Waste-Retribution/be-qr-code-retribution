<?php

namespace App\Models;

use App\Utils\FileFormatPath;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        try{
            $input = $request->validated();
    
            $file = $request->file('image');
            $fileFormatPath = new FileFormatPath('reports', $file);
    
            // $this->create([
            //     'name' => $input['reports_name'],
            //     'price' => $input['price'],
            //     'notes' => $input['notes'],
            //     'payment_image' => $fileFormatPath->storeFile(),
            //     'reports_date' => $input['date'],
            // ]);

            return $fileFormatPath->storeFile();
        } catch (Throwable $e) {
            dump($e->getMessage());
            die();
        }
    }
}
