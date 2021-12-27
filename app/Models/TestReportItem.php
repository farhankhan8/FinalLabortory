<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestReportItem extends Model
{
    use HasFactory;

    public $table = 'test_report_items';

    protected $fillable = [
        'test_id',
        "title",
        'normalRange',
        // 'finalNormalValue',
        'firstCriticalValue',
        'finalCriticalValue',
        'unit',
        "item_index",
        "table_num"
    ];

    public function TestReport(){
        return $this->hasOne(TestReport::class );
    }
    public function pat()
    {
        return $this->belongsTo(AvailableTest::class);

    }
}
