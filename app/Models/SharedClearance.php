<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clearance;
use App\Models\User;

class SharedClearance extends Model
{
    use HasFactory;

    protected $fillable = [
        'clearance_id',
    ];

    /**
     * Get the clearance associated with the shared clearance.
     */
    public function clearance()
    {
        return $this->belongsTo(Clearance::class);
    }

    /**
     * Get the user associated with the shared clearance.
     */
    public function userClearances()
    {
        return $this->hasMany(UserClearance::class);
    }

    /**
     * Get the uploaded clearances associated with the shared clearance.
     */
    public function uploadedClearances()
    {
        return $this->hasMany(UploadedClearance::class);
    }
}
