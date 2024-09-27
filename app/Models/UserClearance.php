<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserClearance extends Model
{
    use HasFactory;

    protected $fillable = [
        'shared_clearance_id',
        'user_id',
    ];

    /**
     * Get the shared clearance associated with the user clearance.
     */
    public function sharedClearance()
    {
        return $this->belongsTo(SharedClearance::class);
    }

    /**
     * Get the user associated with the user clearance.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     /**
     * Get the uploaded clearance for a specific requirement.
     *
     * @param int $requirementId
     * @return UploadedClearance|null
     */
    public function uploadedClearanceFor($requirementId)
    {
        return $this->hasMany(UploadedClearance::class, 'shared_clearance_id', 'shared_clearance_id')
                    ->where('requirement_id', $requirementId)
                    ->where('user_id', $this->user_id)
                    ->first();
    }
}
