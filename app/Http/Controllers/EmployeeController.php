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

        $employees = Employee::paginate(15);
        foreach ($employees as $employee) {
            if ($employee) {
                $contract = Contract::find($employee->contract_id);
                if ($contract) {
                    $employee->contract_id = $contract->name;
                }
            }
        };
        return Response::json($employees);
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

        $response = array('success' => true);
        $response['employee'] = $employee;
        return Response::json($response);

    }

    public function update(Request $request)
    {

        $ssn = $request->input('identity');
        $id = $request->input('id');


        //Check if SSN exists for another employee
        $exist = Employee::where('identity', $ssn)->get();

        if ($exist) {

            foreach ($exist as $emp) {
                if ($emp->id != $id) {
                    return Response::json(array('success' => false, 'message' => 'Update failed!'));
                }
            }


        }

        $newEmployee = $request->all();
        $image = $request->input('image');
        $oldEmployee = Employee::find($id);

        if ($image == '') {
            $image = $oldEmployee->image;
        }

        $response = $oldEmployee->update($newEmployee);
        $oldEmployee->image = $image;
        $oldEmployee->identity = $request->input('identity');
        $response = $response && $oldEmployee->save();


        return Response::json(array('success' => $response,
            'message' => 'Updated Successfully',
            'employee' => $oldEmployee
        ));


    }

    public function destroy($id)
    {

        Employee::destroy($id);
        return Response::json(array('success' => true));
    }
}
