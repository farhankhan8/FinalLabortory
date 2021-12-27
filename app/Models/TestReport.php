<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_performed_id',
        'test_report_item_id',
        'value',
    ];

    protected $appends=["order","table_num"];

    public function report_item(){
        return $this->belongsTo(TestReportItem::class,"test_report_item_id");
    }

    public function GetOrderAttribute(){
        return $this->report_item->item_index;
    }

    public function GetTableNumAttribute(){
        return $this->report_item->table_num;
    }

}
