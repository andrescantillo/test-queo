<?php

namespace Database\Seeders;

use App\Models\Companies;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Companies::updateOrCreate(
            ['name' => 'Exito'],
            [
                'name' => 'Exito',
                'email' => 'test@mail.com',
                'logo' => '',
                'website' => '',
                'created_at' => '2023-02-04 10:00:00',
                'updated_at' => '2023-02-04 10:00:00'
             ]
        );

        Companies::updateOrCreate(
            ['name' => 'Bancolombia'],
            [
                'name' => 'Bancolombia',
                'email' => 'test@mail.com',
                'logo' => '',
                'website' => '',
                'created_at' => '2023-02-04 10:00:00',
                'updated_at' => '2023-02-04 10:00:00'
             ]
        );

        Companies::updateOrCreate(
            ['name' => 'Ecopetrol S.A.S'],
            [
                'name' => 'Ecopetrol S.A.S',
                'email' => 'test@mail.com',
                'logo' => '',
                'website' => '',
                'created_at' => '2023-02-04 10:00:00',
                'updated_at' => '2023-02-04 10:00:00'
             ]
        );

        Companies::updateOrCreate(
            ['name' => 'UNE'],
            [
                'name' => 'UNE',
                'email' => 'test@mail.com',
                'logo' => '',
                'website' => '',
                'created_at' => '2023-02-04 10:00:00',
                'updated_at' => '2023-02-04 10:00:00'
             ]
        );

        Companies::updateOrCreate(
            ['name' => 'Claro'],
            [
                'name' => 'Claro',
                'email' => 'test@mail.com',
                'logo' => '',
                'website' => '',
                'created_at' => '2023-02-04 10:00:00',
                'updated_at' => '2023-02-04 10:00:00'
             ]
        );

        Companies::updateOrCreate(
            ['name' => 'HP'],
            [
                'name' => 'HP',
                'email' => 'test@mail.com',
                'logo' => '',
                'website' => '',
                'created_at' => '2023-02-04 10:00:00',
                'updated_at' => '2023-02-04 10:00:00'
             ]
        );

        Companies::updateOrCreate(
            ['name' => 'Dell'],
            [
                'name' => 'Dell',
                'email' => 'test@mail.com',
                'logo' => '',
                'website' => '',
                'created_at' => '2023-02-04 10:00:00',
                'updated_at' => '2023-02-04 10:00:00'
             ]
        );

        Companies::updateOrCreate(
            ['name' => 'Asus'],
            [
                'name' => 'Asus',
                'email' => 'test@mail.com',
                'logo' => '',
                'website' => '',
                'created_at' => '2023-02-04 10:00:00',
                'updated_at' => '2023-02-04 10:00:00'
             ]
        );

        Companies::updateOrCreate(
            ['name' => 'Alkomprar'],
            [
                'name' => 'Alkomprar',
                'email' => 'test@mail.com',
                'logo' => '',
                'website' => '',
                'created_at' => '2023-02-04 10:00:00',
                'updated_at' => '2023-02-04 10:00:00'
             ]
        );

        Companies::updateOrCreate(
            ['name' => 'Argos'],
            [
                'name' => 'Argos',
                'email' => 'test@mail.com',
                'logo' => '',
                'website' => '',
                'created_at' => '2023-02-04 10:00:00',
                'updated_at' => '2023-02-04 10:00:00'
             ]
        );
    }
}
