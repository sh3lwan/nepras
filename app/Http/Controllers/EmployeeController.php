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
        $toView = array();
        foreach ($employees as $employee) {
            if ($employee) {
                $contract = Contract::find($employee->contract_id);
                if ($contract) {
                    $employee->contract_id = $contract->name;
                    array_push($toView, $employee);
                }
            }
        };

        return Response::json($toView);
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

    public function update(Request $request)
    {

        $ssn = $request->input('identity');
        $id = $request->input('id');

        $exist = Employee::where('identity', $ssn)->get();
        if ($exist) {
            foreach ($exist as $emp) {
                if ($emp->id != $id) {
                    return Response::json(array('success' => false, 'message' => 'Employee update Failed'));
                }
            }
        }

        $employee = Employee::find($id)
            ->update($request->all());

        if ($employee) {
            return Response::json(array('success' => true,
                'message' => 'Employee updated Successfully',
            ));
        }

        return Response::json(array('success' => false, 'message' => 'Employee update failed'));


    }

    public function destroy($id)
    {

        Employee::destroy($id);
        return Response::json(array('success' => true));
    }
}
