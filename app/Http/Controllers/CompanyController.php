<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\CompanyType;

class CompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $company = Company::paginate(5);

        if($request->name)
        {
            $company = Company::where('name', 'like',  '%'.$request->name.'%')->get();
        }

        return view('company', compact('company'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $company = Company::pluck('name', 'id_company');
        $companyType = CompanyType::pluck('company_type', 'id_company_type');

        return view('create_company', compact('company', 'companyType'));
    }

    public function store(Request $request)
    {
        $company = new Company;
        
        $request->request->add(['user_created_company_id' => Auth::id()] );
        $rules = $company->rules();
        
      
        if($this->authorize('is_admin'))
        {
            if($request->company_type_id == '1'){
                $request->request->add(['parent_company_id' => NULL] );
            }

        }

        if(is_null($this->authorize('is_admin')))
        {
            
            if($request->company_type_id == 1 or $request->company_type_id > 2)
            {
                abort(404);
            }

            $request->request->add(['company_type_id' => CompanyType::getIdByName('FILIAL')] );
        }
        $request->validate($rules);

        $company->create($request->all());

        return redirect()->route('company')->with('success', 'Empresa criado com sucesso!');
    }

    public function show($id)
    {
        $companies = new Company;
        $company = $companies->find($id);

        if(is_null($company)) {
            abort(404);
        }
        
        // Configuration GMaps
        $config = array();
        $config['center'] = '-11.873056,-55.498333';
        
        $config['map_height'] = '500px';
        $config['map_width'] = '500px';
        $config['scrollwheel'] = false;
        $config['region'] = 'BR';
        $config['directions'] = false;
        $config['onboundschanged'] = 'if (!centreGot) {
            var mapCentre = map.getCenter();
            marker_0.setOptions({
                position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
            });
        }
        centreGot = true;';
        
        if($company->latitude and $company->longitude)
        {
            $config['center'] = $company->latitude . ',' . $company->longitude;
            $config['zoom'] = '14';
            $marker = array();
            $marker['position'] = $company->latitude . ',' . $company->longitude;
            $marker['infowindows_content'] = $company->latitude . ',' . $company->longitude;        
            app('map')->add_marker($marker);
        }        

        app('map')->initialize($config);
        
        $map = app('map')->create_map();

        return view('show_company', compact('company', 'map'));
    }

    public function edit($id)
    {
        $companies = new Company;
        $company = $companies->find($id);

        if(is_null($company)) {
            abort(404);
        }

        if(is_null($this->authorize('is_admin')))
        {
            if($company->company_type_id == 1)
            {
                abort(404);
            }
        }

        $companySearch = Company::pluck('name', 'id_company');
        $companyType = CompanyType::pluck('company_type', 'id_company_type');
        
        return view('edit_company', compact('company', 'companyType', 'companySearch'));
    }

    public function update(Request $request, Company $company)
    {
        
        $dataCompany = $company->find($request->id_company);

        if(is_null($dataCompany)) {
            abort(404);
        }

        if($this->authorize('is_admin'))
        {
            if($request->company_type_id == '1'){
                $request->request->add(['parent_company_id' => NULL] );
            }

        }

        if(is_null($this->authorize('is_admin')))
        {
            
            if($request->company_type_id == 1 or $request->company_type_id > 2)
            {
                abort(404);
            }

            $request->request->add(['company_type_id' => CompanyType::getIdByName('FILIAL')] );
        }

        $rules = [
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
        
        $request->validate($rules);

        $dataCompany->update($request->all());

        return redirect()->route('company')->with('success', 'Empresa atualizado com sucesso!');
    }

    public function destroy($id, Company $company)
    {
        $dataCompany = $company->find($id);

        if(is_null($dataCompany)) {
            abort(404);
        }

        if(is_null($this->authorize('is_admin')))
        {
            if($company->company_type_id == 1)
            {
                abort(404);
            }
        }
        
        $dataCompany->delete();
        return redirect()->route('company')->with('success', 'Empresa deletado com sucesso!');
    }
}
