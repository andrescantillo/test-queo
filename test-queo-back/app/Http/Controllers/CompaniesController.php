<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponse;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Storage;

class CompaniesController extends Controller
{
    use ApiResponse;


    /**
     * Returns the list of all registered companies
     *
     * @return Response
     *
     * Created at: 2/4/2023, 1:53:51 PM (America/Bogota)
     * @author     Andres Cantillo Nava
     */
    public function index()
    {
        try {
            DB::beginTransaction();
            $companies = Companies::all();
            DB::commit();
            LogActivity::addToLog('The record was showed success','true','ShowAllCompanies',json_encode(""));

            return $this->successResponse(CompanyResource::collection($companies), 'The record was showed success', 200);

        } catch (\Throwable $exception) {

            DB::rollBack();
            LogActivity::addToLog('The record could not be showed','false','ShowAllCompanies',json_encode(""),$exception->getMessage());

            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     *
     * Created at: 2/4/2023, 2:37:31 PM (America/Bogota)
     * @author     Andres Cantillo Nava
     */
    public function store(StoreCompanyRequest $request)
    {
        try {

            $logo = $request->file('logo') ?? null;
            $filename = $logo->getClientOriginalName();
            $filename = str_replace(' ', '', $filename);

            DB::beginTransaction();

            Companies::create([
                'name' => $request->name,
                'email' => $request->email,
                'logo' => "{$this->uploadFile($filename,$logo)}",
                'website' => $request->website,
            ]);
            DB::commit();

            LogActivity::addToLog('The record was saved success','true','StoreCompany',json_encode($request->all()));

            return $this->successResponse([], 'The record was saved success', 200);

        } catch (\Throwable $exception) {
            DB::rollBack();
            LogActivity::addToLog('The record could not be saved','false','StoreCompany',json_encode($request->all()),$exception->getMessage());

            return $this->errorResponse('The record could not be saved', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Companies $company
     * @return \Response
     *
     * Created at: 2/4/2023, 2:37:31 PM (America/Bogota)
     * @author     Andres Cantillo Nava
     */
    public function show(Companies $company)
    {
        try {
            DB::beginTransaction();
            $company = Companies::find($company->id);
            DB::commit();
            LogActivity::addToLog('The record was showed success','true','ShowOneCompany',json_encode(""));

            return $this->successResponse(CompanyResource::make($company), 'The record was showed success', 200);

        } catch (\Throwable $exception) {

            DB::rollBack();
            LogActivity::addToLog('The record could not be showed','false','ShowOneCompany',json_encode(""),$exception->getMessage());

            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCompanyRequest  $request
     * @param  Companies  $company
     * @return Response
     *
     * Created at: 2/4/2023, 2:37:31 PM (America/Bogota)
     * @author     Andres Cantillo Nava
     */
    public function update(UpdateCompanyRequest $request, Companies $company)
    {
        try {

            DB::beginTransaction();

            $company = Companies::find($company->id);
            $company->name = $request->name;
            $company->email = $request->email;
            $company->logo = "";
            $company->website =$request->website;
            $company->save();

            DB::commit();
            LogActivity::addToLog('The record was updated success','true','UpdateCompany',json_encode("Company id:".$company));

            return $this->successResponse([], 'The record was updated success', 200);

        } catch (\Throwable $exception) {

            DB::rollBack();
            LogActivity::addToLog('The record could not be updated','false','UpdateCompany',json_encode("Company id:".$company),$exception->getMessage());

            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Companies  $company
     * @return Response
     *
     * Created at: 2/4/2023, 2:37:31 PM (America/Bogota)
     * @author     Andres Cantillo Nava
     */
    public function destroy(Companies $company)
    {
        try {
            DB::beginTransaction();
            $company->delete();
            DB::commit();
            LogActivity::addToLog('The record was deleted success','true','DeleteCompany',json_encode("Company id:".$company));

            return $this->successResponse([], 'The record was deleted success', 200);

        } catch (\Throwable $exception) {

            DB::rollBack();
            LogActivity::addToLog('The record could not be deleted','false','DeleteCompany',json_encode("Company id:".$company),$exception->getMessage());

            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function uploadFile($fileName,$file){
        return Storage::disk('public')->put('images', $file);
    }
}
