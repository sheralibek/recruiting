<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $guarded = [];

    const RULES = [
        'resume_id' => 'required|integer|exists:resumes,id',
        'vacancy_id' => 'required|integer|exists:vacancies,id',
        'comment' => 'nullable|string|max:250'
    ];

    const UPDATE_RULES = [
        'status' => 'required|boolean'
    ];

    const MESSAGES = [];

    public function vacancy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Vacancy::class, 'vacancy_id', 'id');
    }

    public function resume(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Resume::class, 'resume_id', 'id');
    }
}
