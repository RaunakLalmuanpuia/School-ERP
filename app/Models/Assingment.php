<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assingment extends Model
{
    use HasFactory;
    use SoftDeletes;

     // Empty means all modules are mass assingnable
     protected $guarded = [];
     protected $fillable = [];

     public function subject(): BelongsTo
     {
        return $this->belongsTo(Subjects::class, 'subjects_id');
     }
     
}
