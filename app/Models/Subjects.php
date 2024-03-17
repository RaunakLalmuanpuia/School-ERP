<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
class Subjects extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Empty means all modules are mass assingnable
    protected $guarded = [];
    protected $fillable = [];
    
    //grage
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function asssingment(): HasMany
    {
        return $this->hasMany(Assingment::class);
    }

    public function quiz(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
    
    public function exam(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}
