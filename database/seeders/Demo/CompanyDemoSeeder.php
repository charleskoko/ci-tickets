<?php

namespace Database\Seeders\Demo;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanyDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $felixKouassi = User::where('email', '=', 'felix.kouassi@gmail.com')->first();
        $jeanEvraCrespo = User::where('email', '=', 'evra.crespo@gmail.com')->first();
        $didierZokora = User::where('email', '=', 'didier.zokora@gmail.com')->first();

        $firstActiveCompany = new Company([
            'name' => 'Wawa & Fils',
            'mobile' => '+225 0759584746',
            'website' => 'www.wawaetfils.com',
            'localisation' => 'Abidjan - Treichville',
            'is_active' => true,
        ]);
        $firstNotActiveCompany = new Company([
            'name' => 'M Group',
            'mobile' => '+225 0512345654',
            'website' => 'www.mgroup.com',
            'localisation' => 'Abidjan - Cocody',
            'is_active' => false,
        ]);
        $secondActiveCompany = new Company([
            'name' => 'C&K Entertainment',
            'mobile' => '+225 0512345654',
            'website' => 'www.c&k.ci',
            'localisation' => 'Abidjan - Cocody',
            'is_active' => true,
        ]);

        $firstActiveCompany->owner()->associate($felixKouassi);
        $firstActiveCompany->save();
        $firstNotActiveCompany->owner()->associate($didierZokora);
        $firstNotActiveCompany->save();
        $secondActiveCompany->owner()->associate($jeanEvraCrespo);
        $secondActiveCompany->save();
    }
}
