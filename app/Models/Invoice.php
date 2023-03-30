<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';

    public static $invoices_formatted = array();

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function formatUserInvoice($invoices)
    {
        foreach ($invoices as $item) {
            self::checkStatusInvoice($item);
        }
        return self::$invoices_formatted;
    }

    public static function checkStatusInvoice($invoice)
    {
        if(count(self::$invoices_formatted) > 0){
            foreach (self::$invoices_formatted as $item) {
                if ($invoice['category_id'] == $item['category_id'] && $invoice['status'] == $item['status']) {
                    $item['price'] += $invoice['price'];
                    $item['date'] =  $item['date'] . ' - ' . date('d F Y', strtotime($invoice['created_at']));
                    return;
                    break;
                } else {
                    $invoice['date'] = date('d F Y', strtotime($invoice['created_at']));
                }
            }
        } else {
            $invoice['date'] = date('d F Y', strtotime($invoice['created_at']));
        }
        array_push(self::$invoices_formatted, $invoice);
    }
}
