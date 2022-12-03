<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    const RULES = [
        'position_id' => 'required|integer|exists:positions,id',
        'name' => 'required|string|max:200',
        'cost' => 'required|numeric|between:0,999999999999.99',
        'description' => 'required|min:2|max:65535',
        'skill_ids' => 'required|array',
        'skill_ids.*' => 'integer|exists:skills,id'
    ];

    const MESSAGES = [
        'required' => "To'ldirish shart",
        'integer' => "Raqamlardan iborat bo'lishi shart",
        'exists' => "Bazadan topilmadi",
        'string' => "Matn bo'lishi shart",
        'numeric' => "Raqam bo'lishi shart",
        'min' => "Kamida :attribute ta belgidan iborat bo'lishi shart",
        'max' => "Ko'pi bilan :attribute ta belgidan iborat bo'lishi shart"
    ];

    public function skills(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'vacancy_has_skills', 'vacancy_id', 'skill_id');
    }

    public function responses(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Vacancy::class, 'responses', 'vacancy_id', 'resume_id');
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
