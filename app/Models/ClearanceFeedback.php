<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UploadedClearance;
use App\Models\User;

class ClearanceFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'uploaded_clearance_id',
        'user_id',
        'message',
    ];

    public function uploadedClearance()
    {
        return $this->belongsTo(UploadedClearance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
