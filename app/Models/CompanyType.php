<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    use HasFactory;
    
    protected $table = 'companies_types';
    protected $primaryKey = 'id_company_type';
    
    protected $fillable = [
        'id_company_type', 
        'company_type',
    ];

    public function rules()
    {
        return [
            'company_type' => 'required|string|max:45',
        ];
    }
}
