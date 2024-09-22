<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClearanceRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'clearance_id',
        'requirement',
    ];

    public function clearance()
    {
        return $this->belongsTo(Clearance::class);
    }

    protected static function booted()
    {
        static::created(function ($requirement) {
            $requirement->clearance->increment('number_of_requirements');
        });

        static::deleted(function ($requirement) {
            $requirement->clearance->decrement('number_of_requirements');
        });
    }
}
