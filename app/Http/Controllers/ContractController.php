<?php

namespace App\Http\Controllers;

use App\Contract;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json(Contract::all());
    }


    public function store(Request $request)
    {
        $contract = Contract::create($request->input());
        return Response::json(array('success' => true, 'Contract' => $contract));
    }

    public function show($id)
    {
        return Contact::find($id);
    }


    public function destroy($id)
    {
        Contract::destroy($id);

        Response::json(array('success' => true));
    }
}
