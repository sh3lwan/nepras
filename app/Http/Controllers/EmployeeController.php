<?php namespace App\Http\Controllers;

use App\Contract;
use App\Employee;
use App\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use \Illuminate\Support\Facades\Validator;


class EmployeeController extends Controller
{

    public function index()
    {
        $employees = Employee::all();
        foreach ($employees as $employee) {
            $contractName = Contract::find($employee->contract_id)->name;
            $employee->contract_id = $contractName;
        };

        return Response::json($employees);
    }


    public function show($id)
    {
        $employee = Employee::find($id);
        $family = $employee->family()->orderBy('name');
        return Response::json($family);
    }


    public function store(Request $request)
    {
        $rules = ['identity' => 'unique:employees'];
        $messages = [
            'unique' => 'The :attribute already exists.',];
        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'message' => $validator->messages(),
            ));
        }


        $employee = Employee::create($request->all());
        $employee->image = $request->image;
        $employee->save();
        return Response::json(array('success' => true, 'employee' => $employee));

    }


    public
    function destroy($id)
    {

        Employee::destroy($id);
        return Response::json(array('success' => true));
    }
}
