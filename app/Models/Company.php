<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Facades\JWTAuth;

class Company extends Model
{
    use HasFactory;
    
    protected $table = 'companies';
    protected $primaryKey = 'id_company';

    protected $fillable = [
        'company_type_id',
        'parent_company_id',
        'name',
        'trading_name',
        'cnpj',
        'address',
        'city',
        'state',
        'email',
        'latitude',
        'longitude',
        'user_created_company_id',
    ];

    public function rules()
    {
        return [
            'company_type_id' => 'required|integer|exists:companies_types,id_company_type',
            'parent_company_id' => 'nullable|integer|required_if:company_type_id,==,2',
            'name' => 'required|string|max:45',
            'trading_name' => 'string|max:45',
            'cnpj' => 'required|string|max:20|cpf_ou_cnpj|formato_cpf_ou_cnpj|unique:companies,cnpj',
            'address' => 'required|string|max:45',
            'city' => 'required|string|max:45',
            'state' => 'required|string|max:45',
            'email' => 'nullable|email|max:45',
            'latitude' => 'nullable|numeric|max:20',
            'longitude' => 'nullable|numeric|max:20',
            'user_created_company_id' => 'required|exists:users,id_user',

        ];
    }

    public function companyType()
    {
        return $this->belongsTo(\App\Models\CompanyType::class, 'company_type_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getIdUserApi()
    {
        
        $token = JWTAuth::parseToken();      
        $user = $token->authenticate();
    
        return $user->id_user;
    }
    
}
