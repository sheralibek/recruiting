<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    const RULES = [
        'position_id' => 'required|integer|exists:positions,id',
        'name' => 'required|string|max:200',
        'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
        'all_files' => 'required|array',
        'all_files.*' => 'mimes:pdf,txt,doc,docx|max:100000',
        'work_experience' => 'required|integer|between:0,1200',
        'languages' => 'required|array',
        'languages.*' => 'string|max:20',
        'cost' => 'required|numeric|between:0,999999999999.99',
        'description' => 'required|min:2|max:65535',
        'skill_ids' => 'required|array',
        'skill_ids.*' => 'integer|exists:skills,id'
    ];

    const UPDATE_RULES = [
        'position_id' => 'required|integer|exists:positions,id',
        'name' => 'required|string|max:200',
        'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
        'all_files' => 'nullable|array',
        'all_files.*' => 'mimes:pdf,txt,doc,docx|max:100000',
        'work_experience' => 'required|integer|between:0,1200',
        'languages' => 'required|array',
        'languages.*' => 'string|max:20',
        'cost' => 'required|numeric|between:0,999999999999.99',
        'description' => 'required|min:2|max:65535',
        'skill_ids' => 'required|array',
        'skill_ids.*' => 'integer|exists:skills,id'
    ];

    const MESSAGES = [];

    public function skills(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'resume_has_skills', 'resume_id', 'skill_id');
    }

    public function responses(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Vacancy::class, 'responses', 'resume_id', 'vacancy_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function incrementReadCount(): bool
    {
        $this->views++;
        return $this->save();
    }
}
