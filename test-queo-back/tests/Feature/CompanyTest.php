<?php

namespace Tests\Feature;

use App\Models\Companies;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CompanyTest extends TestCase
{

    /**
     * [Description for authenticate]
     *
     * @return [type]
     *
     *
     * @author     Andres Cantillo Nava
     */
    protected function authenticate()
    {
        // Creating Users
        User::create([
            'name' => 'Test',
            'email'=> 'TestQueo@example.com',
            'password' => $password = bcrypt('123456789')
        ]);
        // Simulated landing
        $response = $this->postJson('api/auth/login',[
            'email' => 'TestQueo@example.com',
            'password' => '123456789',
        ]);

        User::where('email','TestQueo@example.com')->delete();

        Log::info(1, [$response->getContent()]);

        $bodyContent = json_decode($response->getContent());

        return $bodyContent->data->access_token;
    }


    /**
     * [Description for test_create_product]
     *
     * @return [type]
     *
     *
     * @author     Andres Cantillo Nava
     */
    public function testCreateCompany()
    {
        $token = $this->authenticate();

        Storage::fake('uploads');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->postJson('api/companies',[
            'name' => 'TestQueo',
            'email' => 'TestQueo@test.com',
            'logo' => UploadedFile::fake()->image('avatar.jpg', '100', '100')->size(200),
            'website' => '',
            'created_at' => '2023-02-04 10:00:00',
            'updated_at' => '2023-02-04 10:00:00'
        ]);

        //Write the response in laravel.log
        Log::info(1, [$response->getContent()]);

        Companies::where('email','TestQueo@test.com')->delete();

        $response->assertStatus(200);
    }

    /**
     * [Description for test_create_product]
     *
     * @return [type]
     *
     *
     * @author     Andres Cantillo Nava
     */
    public function testGetAllEmployees()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->getJson('api/companies');

        //Write the response in laravel.log
        Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

}
