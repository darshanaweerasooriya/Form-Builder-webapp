<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormFieldValue extends Model
{
    use HasFactory;

    protected $fillable = ['submission_id', 'field_id', 'value'];

    public function field()
    {
        return $this->belongsTo(FormField::class, 'field_id');
    }

    public function submission()
    {
        return $this->belongsTo(FormSubmission::class, 'submission_id');
    }
}
