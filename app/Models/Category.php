<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $table = 'categories';

    protected $fillable = [
        'Cname',
    ];
    public function availableTest()
    {
        return $this->hasMany(AvailableTest::class);

    }

    // public function cata()
    // {
    //     return $this->hasMany(AvailableTestPatient::class);
    // }

    public function test_performeds(){
        return $this->hasManyThrough(TestPerformed::class,AvailableTest::class);
    }
}
