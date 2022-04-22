<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyPostRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success(['companies' => CompanyResource::collection(Company::all())], 'successfully loaded', '200');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyPostRequest $request
     * @return JsonResponse
     */
    public function store(CompanyPostRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $company = new Company($validatedData);
        $company->owner()->associate(Auth::user())->save();

        return $this->success(['company' => CompanyResource::make($company)], 'Successfully created', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Company $company
     * @return JsonResponse
     */
    public function show(Company $company)
    {
        return $this->success(['company' => CompanyResource::make($company->refresh())], 'Successfully loaded', 200);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param CompanyPostRequest $request
     * @param Company $company
     * @return JsonResponse
     */
    public function update(CompanyPostRequest $request, Company $company): JsonResponse
    {
        $validatedData = $request->validated();
        $company->update($validatedData);

        return $this->success(['company' => CompanyResource::make($company->refresh())], 'Successfully updated', 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return JsonResponse
     */
    public function destroy(Company $company):jsonResponse
    {
        $company->delete();

        return $this->success([], 'Successfully deleted', 200);
    }
}
