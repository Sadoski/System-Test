<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use App\Models\CompanyType;

class CompanyApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.role:ADMINISTRADOR|USUARIO');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::all();
        return response()->json($company, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = new Company;
        $request->request->add(['user_created_company_id' => $company->getIdUserApi()] );

        if($this->authorize('is_admin_api'))
        {
            if($request->company_type_id == '1'){
                $request->request->add(['parent_company_id' => NULL] );
            }
        }

        if(is_null($this->authorize('is_admin_api')))
        {
            
            if($request->company_type_id == 1 or $request->company_type_id > 2)
            {
                    return response()->json('Tipo de empresa não permitido', 400);
            }

            $request->request->add(['company_type_id' => CompanyType::getIdByName('FILIAL')] );
        }

        $validator = Validator::make($request->all(), $company->rules());

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $company->create($request->all());

        return response()->json($company, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $companies = new Company;
        $company = $companies->find($id);

        if(is_null($company)) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }

        return response()->json($company, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $dataCompany = $company->find($request->id_company);

        if($dataCompany) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }

        if(is_null($this->authorize('is_admin')))
        {
            if($dataCompany->company_type_id == 1)
            {
                return response()->json(['message' => 'Operação invalida para o tipo de empresa'], 404);
            }
        }

        $rules = $rules = [
            'company_type_id' => 'required|integer|exists:companies_types,id_company_type',
            'parent_company_id' => 'nullable|integer|required_if:company_type_id,==,2',
            'name' => 'required|string|max:45',
            'trading_name' => 'string|max:45',
            'cnpj' => 'required|string|max:20|cpf_ou_cnpj|formato_cpf_ou_cnpj|unique:companies,cnpj,'. $request->id_company . ',id_company',
            'address' => 'required|string|max:45',
            'city' => 'required|string|max:45',
            'state' => 'required|string|max:45',
            'email' => 'nullable|email|max:45',
            'latitude' => 'nullable|numeric|max:20',
            'longitude' => 'nullable|numeric|max:20',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $company->update($request->all());

        return response()->json($company, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Company $company)
    {
        $dataCompany = $company->find($id);

        if(is_null($dataCompany)) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }

        if(is_null($this->authorize('is_admin_api')))
        {
            if($dataCompany->company_type_id == 1)
            {
                return response()->json(['message' => 'Operação invalida para o tipo de empresa'], 404);
            }
        }

        $dataCompany->delete();

        return response()->json(null, 204);
    }
}
