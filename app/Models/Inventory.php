<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    public $table = 'inventories';

    protected $fillable = [
        'inventoryName',
        'inventoryUnit',
        'remainingItem',
       
    ];
    public function available_tests()
    {
        return $this->belongsToMany(AvailableTest::class, 'available_test_inventories');
    }
}
