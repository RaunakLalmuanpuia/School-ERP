<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Empty means all modules are mass assingnable
    protected $guarded = [];

    public function students():HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function subjects():HasMany
    {
        return $this->hasMany(Subjects::class);
    }

}
