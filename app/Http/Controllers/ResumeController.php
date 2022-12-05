<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Repositories\ResumeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class ResumeController extends Controller
{
    public ResumeRepository $resumeRepository;

    public function __construct(ResumeRepository $repository)
    {
        $this->resumeRepository = $repository;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'resumes' => Resume::all()
        ]);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $resume = Resume::findOrFail($id);

        if (request()->cookie(auth()->id() . $resume->id) == '') {
            cookie(auth()->id() . $resume->id, '1', 60);
            $resume->incrementReadCount();
        }

        return response()->json([
            'success' => true,
            'resume' => $resume
        ]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $errors = Validator::make($request->all(), Resume::RULES, Resume::MESSAGES);

        if ($errors->fails())
            return response()->json([
                'success' => false,
                'errors' => $errors->errors()
            ]);

        $result = $this->resumeRepository->store($request);

        return response()->json([
            'success' => $result['status'],
            'message' => $result['message']
        ]);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $errors = Validator::make($request->all(), Resume::UPDATE_RULES, Resume::MESSAGES);

        if ($errors->fails())
            return response()->json([
                'success' => false,
                'errors' => $errors->errors()
            ]);

        $vacancy = Resume::where(['id' => $id, 'user_id' => auth()->id()])->firstOrFail();

        if (!$vacancy)
            return response()->json([
                'success' => false,
                'message' => 'Vacancy not found!'
            ]);

        $result = $this->resumeRepository->update($request, $vacancy);

        return response()->json([
            'success' => $result['status'],
            'message' => $result['message']
        ]);
    }

    public function delete($id): \Illuminate\Http\JsonResponse
    {
        $vacancy = Resume::where(['id' => $id, 'user_id' => auth()->id()])->firstOrFail();

        if (!$vacancy)
            return response()->json([
                'success' => false,
                'message' => 'Vacancy not found!'
            ]);

        $result = $this->resumeRepository->delete($vacancy);

        return response()->json([
            'success' => $result['status'],
            'message' => $result['message']
        ]);
    }
}
