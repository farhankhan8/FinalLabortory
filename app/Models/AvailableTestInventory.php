<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableTestInventory extends Model
{
    use HasFactory;

    public $table = 'available_test_inventories';

    protected $fillable = [
        'available_test_id','inventory_id','itemUsed'
    ];

    public function inventory(){
        return $this->belongsTo(Inventory::class);
    }


}
