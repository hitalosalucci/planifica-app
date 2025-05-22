<?php

namespace Tests\Integration\User;

use App\DTOs\User\CreateUserDTO;
use App\Repositories\User\UserRepository;
use App\Services\User\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

class UserIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private UserService $userService;

    //Injetar dependência no setUp
    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    public function testCreateUserSuccessfully(): void
    {
        $faker = \Faker\Factory::create();

        $dto = new CreateUserDTO(
            name: $faker->name,
            email: $faker->unique()->safeEmail,
            password: 'secret123@#3421)901'
        );

        $user = $this->userService->create($dto);

        $this->assertNotNull($user, 'Usuário é nulo');
        $this->assertEquals($dto->name, $user->name, 'Nome incorreto');
        $this->assertEquals($dto->email, $user->email, 'Email incorreto');

        $this->assertDatabaseHas('users', [
            'email' => $dto->email,
            'name' => $dto->name,
        ]);
    }

    public function testCreateUserUnsuccessfully(): void
    {
        $dto = new CreateUserDTO(
            name: '',
            email: 'escrevendo-email-invalido',
            password: ''
        );

        try {
            $user = $this->userService->create($dto);
            $this->fail('Nenhuma exceção lançada. Teste falhou', $user);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->assertTrue(true);
        }
        
    }

    public function testCreateUserPasswordEncryptedSuccessfully(): void
    {
        $faker = \Faker\Factory::create();

        $dto = new CreateUserDTO(
            name: $faker->name,
            email: $faker->unique()->safeEmail,
            password: '@!@#A4334%$ã12345678@qwe#asz0asda=+-='
        );

        $password = $dto->password;

        $user = $this->userService->create($dto);

        $this->assertNotEquals($password, $user->password, 'Senha não foi criptografada');

        $this->assertTrue(
            \Illuminate\Support\Facades\Hash::check($password, $user->password),
            'A senha criptografada não bate com a senha sem criptografia'
        );
        
    }
    
}
