<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClearanceRequirement;

class Clearance extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_name',
        'description',
        'units',
        'type',
        'number_of_requirements',
    ];

    // If you have a requirements relationship
    public function requirements()
    {
        return $this->hasMany(ClearanceRequirement::class);
    }
}
