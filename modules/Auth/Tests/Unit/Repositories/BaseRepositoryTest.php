<?php

namespace Auth\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Auth\Models\User;
use Modules\Auth\Repositories\BaseRepository;
use Modules\Auth\Repositories\User\UserRepository;
use Modules\Auth\Repositories\User\UserRepositoryInterface;
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

    public function testConstructorWithValidModelClass(): void
    {
        $this->assertInstanceOf(UserRepository::class, $this->userRepository);
    }

    public function testConstructorWithInvalidModelClass(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new class () extends BaseRepository {
            protected string $modelClass = 'NonExistentClass';
        };
    }

    public function testAll(): void
    {
        User::factory()->count(3)->create();
        $users = $this->userRepository->all();
        $this->assertCount(3, $users);
    }

    public function testPaginate(): void
    {
        User::factory()->count(15)->create();
        $users = $this->userRepository->paginate(10);
        $this->assertCount(10, $users);
        $this->assertInstanceOf(LengthAwarePaginator::class, $users);
    }

    public function testCreate(): void
    {
        $userData = User::factory()->make()->toArray();
        $user = $this->userRepository->create($userData);
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
        $this->assertInstanceOf(User::class, $user);
    }

    public function testFind(): void
    {
        $user = User::factory()->create();
        $foundUser = $this->userRepository->find($user->id);
        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }

    public function testFindOrFail(): void
    {
        $user = User::factory()->create();
        $foundUser = $this->userRepository->findOrFail($user->id);
        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }

    public function testUpdate(): void
    {
        $user = User::factory()->create();
        $updateData = ['name' => 'Updated Name'];
        $updated = $this->userRepository->update($user, $updateData);
        $this->assertTrue($updated);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated Name']);
    }

    public function testDelete(): void
    {
        $user = User::factory()->create();
        $deleted = $this->userRepository->delete($user);
        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function testUpdateOrCreate(): void
    {
        $attributes = ['email' => 'unique@example.com'];
        $values = ['name' => 'John Doe'];
        $user = $this->userRepository->updateOrCreate($attributes, $values);
        $this->assertDatabaseHas('users', $attributes + $values);
        $this->assertInstanceOf(User::class, $user);
    }

    public function testGetBy(): void
    {
        $users = User::factory()->count(5)->create(['name' => 'John Doe']);
        $result = $this->userRepository->getBy(['name' => 'John Doe']);
        $this->assertCount(5, $result);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $result);
    }

    public function testGetByTakeOne(): void
    {
        $user = User::factory()->create(['name' => 'John Doe']);
        $result = $this->userRepository->getBy(['name' => 'John Doe'], true);
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($user->id, $result->id);
    }
}
