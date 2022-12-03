<?php

namespace App\Repositories;

use App\Models\Vacancy;

class VacancyRepository
{
    public function store($request): array
    {
        try {
            $vacancy = Vacancy::create([
                'user_id' => auth()->id(),
                'position_id' => $request->position_id,
                'name' => $request->name,
                'cost' => $request->cost,
                'description' => $request->description
            ]);
            $vacancy->skills()->attach($request->skill_ids);

            return [
                'status' => true,
                'message' => 'Success'
            ];
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function update($request, $vacancy): array
    {
        try {
            $vacancy->update([
                'position_id' => $request->position_id,
                'name' => $request->name,
                'cost' => $request->cost,
                'description' => $request->description
            ]);
            $vacancy->skills()->sync($request->skill_ids);

            return [
                'status' => true,
                'message' => 'Success'
            ];
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function delete($vacancy): array
    {
        try {
            $vacancy->delete();

            return [
                'status' => true,
                'message' => 'Success'
            ];
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage()
            ];
        }
    }
}
