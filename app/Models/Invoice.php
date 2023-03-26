<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';

    private static $invoices_formatted = array();

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function formatUserInvoice($invoices){
        // $result = array();
        foreach ($invoices as $item) {
            $check = self::checkStatusInvoice($item);
            
            // if(!$check['status']){
            //     array_push($result, $item);
            // } else {
            //     $result[$check['index']]['price'] += $item['price'];
            // }
        }
        return self::$invoices_formatted;
    }
    
    public static function checkStatusInvoice($invoice){
        $index = 0;
        foreach (self::$invoices_formatted as $item) {
            if($invoice['category_id'] == $item['category_id']){
                $item['price'] += $invoice['price'];
                return [
                    'status' => true,
                    'index' => $index,
                ];
                break;
            }
            $index++;
        }

        array_push(self::$invoices_formatted, $invoice);

        return [
            'status' => false,
            'index' => $index,
        ];
    }


}
