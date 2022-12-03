<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use App\Repositories\VacancyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class VacancyController extends Controller
{
    public VacancyRepository $vacancyRepository;

    public function __construct(VacancyRepository $repository)
    {
        $this->vacancyRepository = $repository;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'vacancies' => Vacancy::all()
        ]);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $vacancy = Vacancy::findOrFail($id);

        if (request()->cookie(auth()->id() . $vacancy->id) == '') {
            cookie(auth()->id() . $vacancy->id, '1', 60);
            $vacancy->incrementReadCount();
        }

        return response()->json([
            'success' => true,
            'errors' => $vacancy
        ]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $errors = Validator::make($request->all(), Vacancy::RULES, Vacancy::MESSAGES);

        if ($errors->fails())
            return response()->json([
                'success' => false,
                'errors' => $errors->errors()
            ]);

        $result = $this->vacancyRepository->store($request);

        return response()->json([
            'success' => $result['status'],
            'message' => $result['message']
        ]);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $errors = Validator::make($request->all(), Vacancy::RULES, Vacancy::MESSAGES);

        if ($errors->fails())
            return response()->json([
                'success' => false,
                'errors' => $errors->errors()
            ]);

        $vacancy = Vacancy::where(['id' => $id, 'user_id' => auth()->id()])->firstOrFail();

        if (!$vacancy)
            return response()->json([
                'success' => false,
                'message' => 'Vacancy not found!'
            ]);

        $result = $this->vacancyRepository->update($request, $vacancy);

        return response()->json([
            'success' => $result['status'],
            'message' => $result['message']
        ]);
    }

    public function delete($id): \Illuminate\Http\JsonResponse
    {
        $vacancy = Vacancy::where(['id' => $id, 'user_id' => auth()->id()])->firstOrFail();

        if (!$vacancy)
            return response()->json([
                'success' => false,
                'message' => 'Vacancy not found!'
            ]);

        $result = $this->vacancyRepository->delete($vacancy);

        return response()->json([
            'success' => $result['status'],
            'message' => $result['message']
        ]);
    }
}
