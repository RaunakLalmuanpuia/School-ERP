<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Empty means all modules are mass assingnable
    protected $guarded = [];

    public function student(){
        return $this->hasMany(Student::class);
    }
    public function subjects(){
        return $this->hasMany(Subjects::class);
    }

}
