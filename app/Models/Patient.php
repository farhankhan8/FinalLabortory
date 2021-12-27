<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    public $table = 'patients';

    protected $fillable = [
        'Pname',
        'email',
        'phone',
        'start_time',
        'gend',
        'dob',
        'patient_category_id',
    ];

    public function availableTest()
    {
        return $this->hasMany(AvailableTest::class);

    }

    public function testPerformed()
    {
        return $this->hasMany(TestPerformed::class);
    }

    public function category(){
        return $this->hasOne(PatientCategory::class,"id","patient_category_id");
    }
}
