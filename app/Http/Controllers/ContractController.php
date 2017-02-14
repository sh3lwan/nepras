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


    public function create()
    {

    }

    public function store(Request $request)
    {
        return 'Hello';
    }

    public function show($id)
    {
        return Contact::find($id);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
