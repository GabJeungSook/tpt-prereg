<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'documentable');
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
