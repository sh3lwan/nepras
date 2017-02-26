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

        $member = new FamilyMember();
        $member->name = $request->input('name');
        $member->birth_date = $request->input('birth_date');
        $member->relative_id = $request->input('relative_id');
        $member->relation = $request->input('relation');
        $member->save();
        return Response::json(array('success' => true, 'member' => $member));
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
        $member->update($data);
        $member->relation = $data['relation'];
        $member->save();
        return Response::json(array('success' => true));
    }

    public function destroy($id)
    {
        FamilyMember::destroy($id);
        return Response::json(array('success' => true));
    }
}
