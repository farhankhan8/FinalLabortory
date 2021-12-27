<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableTest extends Model
{
    use HasFactory;
    public $table = 'available_tests';

    protected $fillable = [
        'category_id',
        'name',
        'testFee',
        'urgentFee',
        'stander_timehour',
        'urgent_timehour',
        'resultValueCount',
        'type',
        'testCode',
//        'initialNormalValue',
//        'finalNormalValue',
//        'firstCriticalValue',
//        'finalCriticalValue',
//        'units',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);

    }

    public function testPerformed()
    {
        return $this->hasMany(TestPerformed::class);

    }

    public function patient() 
    {
        return $this->belongsTo(Patient::class);

    }

    public function inventories()
    {
        return $this->belongsToMany(Inventory::class, 'available_test_inventories');
    }

    public function available_test_inventories()
    {
        return $this->hasMany(AvailableTestInventory::class);
    }

    public function TestReportItems()
    {
        return $this->hasMany(TestReportItem::class,'test_id');
    }

}
