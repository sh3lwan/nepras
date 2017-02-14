<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;


class EmployeeController extends Controller
{

    public function index()
    {
        $employees = Employee::all();
        foreach ($employees as $employee) {
            $contractID = $employee->contract_id;
            $contractName = Contract::find($contractID)->name;
            $employee->contract_id = $contractName;

        }
        return Response::json($employees);
    }

    public function show($identity)
    {
        if (User::where('identity', '=', $identity)->exists()) {
            return false;
        }
        return true;
    }

    public function store(Request $request)
    {

        $response = array('success' => false);

        $destinationPath = "avatars/";
        $image = $request->file('image');

        if ($image->isValid()) {


            $ext = $image->getClientOriginalExtension();
            $fileName = time() . uniqid() . '.' . $ext;


            $uploadSuccess = $image->move($destinationPath, $fileName);


            if ($uploadSuccess) {
                $employee = $request->all();
                $newEmployee = Employee::create($employee);
                $newEmployee->image = $fileName;
                $newEmployee->save();
                $response['success'] = true;
                $response['employee'] = $newEmployee;
            }

        }


        return Response::json($response);

    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        Employee::destroy($id);
        return Response::json(array('success' => true));
    }
}
