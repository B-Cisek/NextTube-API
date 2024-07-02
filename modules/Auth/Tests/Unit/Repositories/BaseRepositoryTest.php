<?php

namespace Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Models\User;
use Modules\Auth\Repositories\BaseRepository;
use Modules\Auth\Repositories\User\UserRepository;
use Modules\Auth\Repositories\User\UserRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BaseRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository();
    }

    #[Test]
    public function constructor_with_valid_model_class(): void
    {
        $this->assertInstanceOf(UserRepository::class, $this->userRepository);
    }

    #[Test]
    public function constructor_with_invalid_model_class(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new class () extends BaseRepository {
            protected string $modelClass = 'NonExistentClass';
        };
    }

    #[Test]
    public function all(): void
    {
        User::factory()->count(3)->create();
        $users = $this->userRepository->all();
        $this->assertCount(3, $users);
    }

    #[Test]
    public function paginate(): void
    {
        User::factory()->count(15)->create();
        $users = $this->userRepository->paginate(10);
        $this->assertCount(10, $users);
        $this->assertInstanceOf(LengthAwarePaginator::class, $users);
    }

    #[Test]
    public function create(): void
    {
        $user = $this->userRepository->create([
            'username' => 'testusername',
            'email' => 'test@example.com',
            'password' => 'testpassword',
        ]);

        $this->assertDatabaseHas('users', ['email' => $user->email]);
        $this->assertInstanceOf(User::class, $user);
    }

    #[Test]
    public function find(): void
    {
        $user = User::factory()->create();
        $foundUser = $this->userRepository->find($user->id);
        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }

    #[Test]
    public function find_or_fail(): void
    {
        $user = User::factory()->create();
        $foundUser = $this->userRepository->findOrFail($user->id);
        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }

    #[Test]
    public function update(): void
    {
        $user = User::factory()->create();
        $updateData = ['username' => 'updatedName'];
        $updated = $this->userRepository->update($user, $updateData);
        $this->assertTrue($updated);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'username' => 'updatedName']);
    }

    #[Test]
    public function test_delete(): void
    {
        $user = User::factory()->create();
        $deleted = $this->userRepository->delete($user);
        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    #[Test]
    public function update_or_create(): void
    {
        $attributes = [
            'email' => 'unique@example.com',
            'password' => Hash::make('password')
        ];
        $values = ['username' => 'John Doe'];
        $user = $this->userRepository->updateOrCreate($attributes, $values);
        $this->assertDatabaseHas('users', $attributes + $values);
        $this->assertInstanceOf(User::class, $user);
    }

    #[Test]
    public function get_by(): void
    {
        User::factory()->make()->create([
            'username' => 'JohnDoe',
            'email' => 'johndoe@example.com',
            'password' => 'password'
        ]);

        User::factory()->count(9)->create();

        $result = $this->userRepository->getBy(['username' => 'JohnDoe']);
        $this->assertCount(10, $this->userRepository->all());
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Collection::class, $result);
    }

    #[Test]
    public function get_by_take_one(): void
    {
        $user = User::factory()->create(['username' => 'JohnDoe']);
        $result = $this->userRepository->getBy(['username' => 'JohnDoe'], true);
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($user->id, $result->id);
    }
}
