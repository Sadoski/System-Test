<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyType;

class CompaniesTypesSeeder extends Seeder
{
    static $types_of_companies = [
        ['id_company_type' => 1, 'company_type' => 'MATRIZ',],
        ['id_company_type' => 2, 'company_type' => 'FILIAL',], 
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        Foreach (self::$types_of_companies as $company_type) {
            CompanyType::create($company_type);
        }
    }
}
