<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\Resume;
use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResponseController extends Controller
{
    public ResponseRepository $responseRepository;

    public function __construct(ResponseRepository $repository)
    {
        $this->responseRepository = $repository;
    }

    public function indexVacancy($id): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'vacancies' => Response::with(['vacancy' => function ($query) {
                $query->with('user');
            }])->whereHas('vacancy', function ($query) {
                $query->where('user_id', auth()->id());
            })->get()
        ]);
    }

    public function indexResume(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'vacancies' => Response::with(['resume' => function ($query) {
                $query->with('user');
            }])->whereHas('resume', function ($query) {
                $query->where('user_id', auth()->id());
            })->get()
        ]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $errors = Validator::make($request->all(), Response::RULES, Response::MESSAGES);

        if ($errors->fails())
            return response()->json([
                'success' => false,
                'errors' => $errors->errors()
            ]);

        Resume::findOrFail($request->resume_id);

        $result = $this->responseRepository->store($request);

        return response()->json([
            'success' => $result['status'],
            'message' => $result['message']
        ]);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $errors = Validator::make($request->all(), Response::UPDATE_RULES, Response::MESSAGES);

        if ($errors->fails())
            return response()->json([
                'success' => false,
                'errors' => $errors->errors()
            ]);

        $vacancy = Response::whereId($id)->whereHas('vacancy', function ($query) {
            $query->where('user_id', auth()->id());
        })->firstOrFail();

        if (!$vacancy)
            return response()->json([
                'success' => false,
                'message' => 'Vacancy not found!'
            ]);

        $result = $this->responseRepository->update($request, $vacancy);

        return response()->json([
            'success' => $result['status'],
            'message' => $result['message']
        ]);
    }
}
