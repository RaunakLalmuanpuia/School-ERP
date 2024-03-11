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

    public function students(){
        return $this->hasMany(Student::class, 'user_id');
    }

    public function subjects(){
        return $this->hasMany(Subjects::class, 'class_id');
    }

}
