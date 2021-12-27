<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCategory extends Model
{
    use HasFactory;
    public $table = 'patient_categories';

    protected $fillable = [
        'Pcategory',
        'discount',

    ];
    // public function catagory()
    // {
    //     return $this->belongsTo(Catagory::class);

    // }

     public function getAllPatients()
     {
         return $this->hasMany(Patient::class);

     }
}
