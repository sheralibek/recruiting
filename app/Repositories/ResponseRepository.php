<?php

namespace App\Repositories;

use App\Models\Response;

class ResponseRepository
{
    public function store($request): array
    {
        try {
            Response::create([
                'vacancy_id' => $request->vacancy_id,
                'resume_id' => $request->resume_id,
                'comment' => $request->comment
            ]);

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

    public function update($status, $response): array
    {
        try {
            $response->update([
                'status' => $status ? 1 : 3
            ]);

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
