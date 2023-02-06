<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogActivity;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Jobs\SendEmailJob;
use App\Traits\ApiResponse;

class EmployeesController extends Controller
{

    use ApiResponse;
    /**
     * Returns the list of all registered employees
     *
     * @return Response
     *
     * Created at: 2/4/2023, 2:37:31 PM (America/Bogota)
     * @author     Andres Cantillo Nava
     */
    public function index()
    {
        try {
            DB::beginTransaction();
            $employees = Employees::all();
            DB::commit();
            LogActivity::addToLog('The record was showed success','true','ShowAllEmployees',json_encode(""));

            return $this->successResponse(EmployeeResource::collection($employees), 'The record was showed success', 200);

        } catch (\Throwable $exception) {

            DB::rollBack();
            LogActivity::addToLog('The record could not be showed','false','ShowAllEmployees',json_encode(""),$exception->getMessage());

            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreEmployeeRequest  $request
     * @return Response
     *
     * Created at: 2/4/2023, 2:37:31 PM (America/Bogota)
     * @author     Andres Cantillo Nava
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            DB::beginTransaction();
            $employee = Employees::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'company_id' => $request->company_id,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            DB::commit();

            SendEmailJob::dispatch($employee);

            LogActivity::addToLog('The record was saved success','true','StoreEmployee',json_encode($request->all()));
            return $this->successResponse([], 'The record was saved success', 200);

        } catch (\Throwable $exception) {
            DB::rollBack();

            LogActivity::addToLog('The record could not be saved','false','StoreEmployee',json_encode($request->all()),$exception->getMessage());
            return $this->errorResponse('The record could not be saved', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employees  $employee
     * @return \Illuminate\Http\Response
     *
     * Created at: 2/4/2023, 2:37:31 PM (America/Bogota)
     * @author     Andres Cantillo Nava
     */
    public function show(Employees $employee)
    {
        try {
            DB::beginTransaction();
            $employee = Employees::find($employee->id);
            DB::commit();

            LogActivity::addToLog('The record was showed success','true','ShowOneEmployee',json_encode(""));
            return $this->successResponse(EmployeeResource::make($employee), 'The record was showed success', 200);

        } catch (\Throwable $exception) {

            DB::rollBack();
            LogActivity::addToLog('The record could not be showed','false','ShowOneEmployee',json_encode(""),$exception->getMessage());

            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employees  $employee
     * @return \Illuminate\Http\Response
     *
     * Created at: 2/4/2023, 2:37:31 PM (America/Bogota)
     * @author     Andres Cantillo Nava
     */
    public function update(UpdateEmployeeRequest $request, Employees $employee)
    {
        try {
            DB::beginTransaction();
            $employee->update($request->all());
            DB::commit();
            LogActivity::addToLog('The record was updated success','true','UpdateEmployee',json_encode("Employee id:".$employee));

            return $this->successResponse([], 'The record was updated success', 200);

        } catch (\Throwable $exception) {

            DB::rollBack();
            LogActivity::addToLog('The record could not be updated','false','UpdateEmployee',json_encode("Employee id:".$employee),$exception->getMessage());

            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employees  $employee
     * @return \Illuminate\Http\Response
     *
     * Created at: 2/4/2023, 2:37:31 PM (America/Bogota)
     * @author     Andres Cantillo Nava
     */
    public function destroy(Employees $employee)
    {
        try {
            DB::beginTransaction();
            $employee->delete();
            DB::commit();
            LogActivity::addToLog('The record was deleted success','true','DeleteEmployee',json_encode("Employee id:".$employee));

            return $this->successResponse([], 'The record was deleted success', 200);

        } catch (\Throwable $exception) {

            DB::rollBack();
            LogActivity::addToLog('The record could not be deleted','false','DeleteEmployee',json_encode("Employee id:".$employee),$exception->getMessage());

            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
