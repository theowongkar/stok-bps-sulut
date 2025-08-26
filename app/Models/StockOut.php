<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    /** @use HasFactory<\Database\Factories\StockOutFactory> */
    use HasFactory;

    protected $fillable = [
        'item_id',
        'employee_id',
        'quantity',
        'note',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
