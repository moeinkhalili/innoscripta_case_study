<?php

namespace Feature\Endpoint;

use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    #[DataProvider('signUpProvider')]
    public function test_sign_up(int $expectedStatusCode, ?string $name, ?string $email, ?string $password, ?bool $duplicateEmail = false): void
    {
        if ($duplicateEmail) {
            User::factory()->create(['email' => $email]);
        }

        $this
            ->withHeader('Accept', 'application/json')
            ->post('/api/users/sign-up', [
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ])
            ->assertStatus($expectedStatusCode);

        if ($expectedStatusCode === Response::HTTP_OK) {
            $this->assertDatabaseHas('users', [
                'email' => $email,
            ]);
        }
    }

    #[DataProvider('signInProvider')]
    public function test_sign_in(int $expectedStatusCode, ?string $email, ?string $password, ?bool $notExistEmail = false): void
    {
        User::factory()->create(['email' => $notExistEmail ? fake()->email : ($email ?? fake()->email), 'password' => ($password ?? fake()->password)]);

        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post('/api/users/sign-in', [
                'email' => $email,
                'password' => $password,
            ])
            ->assertStatus($expectedStatusCode);

        if ($expectedStatusCode === Response::HTTP_OK) {
            $response
                ->assertJsonStructure(['token'])
                ->assertJson(fn ($json) => $json->whereType('token', 'string'));
        }
    }

    public function test_get_current_user(): void
    {
        $user = User::factory()->create();

        $this
            ->withHeader('Accept', 'application/json')
            ->actingAs($user, 'sanctum')
            ->get('/api/users/current')
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                ],
            ])
            ->assertStatus(Response::HTTP_OK);
    }

    public function test_logout(): void
    {
        $user = User::factory()->create();

        $this
            ->withHeader('Accept', 'application/json')
            ->actingAs($user, 'sanctum')
            ->post('/api/users/sign-out')
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public static function signUpProvider(): array
    {
        return [
            // Correct data
            [
                'expectedStatusCode' => Response::HTTP_OK,
                'name' => 'John Doe',
                'email' => fake()->email,
                'password' => '12345678',
            ],
            // Empty name
            [
                'expectedStatusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'name' => null,
                'email' => fake()->email,
                'password' => '12345678',
            ],
            // empty email
            [
                'expectedStatusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'name' => 'John Doe',
                'email' => null,
                'password' => '12345678',
            ],
            // Empty password
            [
                'expectedStatusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'name' => 'John Doe',
                'email' => fake()->email,
                'password' => null,
            ],
            // duplicate email
            [
                'expectedStatusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'name' => 'John Doe',
                'email' => fake()->email,
                'password' => null,
                'duplicateEmail' => true,
            ],
        ];
    }

    public static function signInProvider(): array
    {
        return [
            // Correct data
            [
                'expectedStatusCode' => Response::HTTP_OK,
                'email' => fake()->email,
                'password' => '12345678',
            ],
            // Empty email
            [
                'expectedStatusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'email' => null,
                'password' => '12345678',
            ],
            // Empty password
            [
                'expectedStatusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'email' => fake()->email,
                'password' => null,
            ],
        ];
    }
}
