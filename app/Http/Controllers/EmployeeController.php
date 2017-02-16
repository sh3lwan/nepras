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
            $contractID = $employee->contract_id;
            $contractName = Contract::find($contractID)->name;
            $employee->contract_id = $contractName;

        }
        return Response::json($employees);
    }

    public function store(Request $request)
    {
        $rules = ['identity' => 'unique:employees'];
        $messages = [
            'unique' => 'The :attribute already exists.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'message' => $validator->messages(),
            ));
        }

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
        $employee = Employee::find($id);
        return $request->input();

    }


    public function destroy($id)
    {

        Employee::destroy($id);
        return Response::json(array('success' => true));
    }
}
