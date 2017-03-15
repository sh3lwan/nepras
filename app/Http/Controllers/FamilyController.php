<?php

namespace App\Http\Controllers;

use App\Employee;
use App\FamilyMember;
use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;

class FamilyController extends Controller
{

    public function index()
    {
        return Response::json(FamilyMember::all());
    }


    public function store(Request $request)
    {

        $name = $request->input('name');
        $relative_id = $request->input('relative_id');
        $birth_date = $request->input('birth_date');

        $member = new FamilyMember();

        $member->name = $name;
        $member->relative_id = $relative_id;
        $member->birth_date = $birth_date;
        $response = $member->save();
        return Response::json(array('success' => $response, 'member' => $member));

    }

    public function show($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $family = $employee->family;
            return Response::json(array('success' => true, 'family' => $family));
        }
        return Response::json(array('success' => false));
    }


    public function update(Request $request, $id)
    {
        $data = $request->input('data');
        $member = FamilyMember::find($id);
        $response = $member->update($data);
        $member->relation = $data['relation'];
        $response = $response && $member->save();
        return Response::json(array('success' => $response, 'member' => $member));
    }

    public function destroy($id)
    {
        FamilyMember::destroy($id);
        return Response::json(array('success' => true));
    }
}
