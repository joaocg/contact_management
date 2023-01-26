<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\User;

class ContactTest extends TestCase
{
    private $faker;
    private $user;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        parent::setUp();
        $this->faker = Faker::create('en_US');
        $this->user = User::factory()->make();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testValidationRegisterNoErrors()
    {

        $nameTeste = Str::random($length = 10);
        $numberTeste = $this->faker->numerify('#########');
        $emailTeste = $this->faker->email();

        $this->actingAs($this->user);

        $response = $this->post(route('contacts.store'), [
            'name' => 'Teste '.$nameTeste,
            'contact' => $numberTeste,
            'email' => $emailTeste
        ]);
        $response->assertSessionHasNoErrors();
    }

    public function testValidationRegisterErrorPhone()
    {

        $nameTeste = Str::random($length = 10);
        $numberTeste = $this->faker->numerify('##########');
        $emailTeste = $this->faker->email();

        $this->actingAs($this->user);
        $response = $this->post(route('contacts.store'), [
            'name' => 'Teste '.$nameTeste,
            'contact' => $numberTeste,
            'email' => $emailTeste
        ]);

        $errors = session('errors');
        $response->assertSessionHasErrors();
        $this->assertEquals($errors->get('contact')[0],"The contact must not be greater than 9 characters.");
    }
}
