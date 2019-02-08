<?php

namespace Tests;

use App\Access;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;

    protected $followRedirects = true;

    protected $faker;
    protected $user;
    protected $admin;
    protected $acccess;

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        // when using sqlite, allow foreign keys
        if (\DB::connection() instanceof \Illuminate\Database\SQLiteConnection) {
            \DB::statement(\DB::raw('PRAGMA foreign_keys=1'));
        }

        return $app;
    }

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $this->withoutMiddleware();
        #$this->withoutExceptionHandling();
        $this->artisan('db:seed');
        $this->faker = Faker::create();
        $this->user = factory(User::class)->create();
        $this->admin = $this->createAdmin();
        $this->access = Access::firstOrFail();
        $this->access->users()->attach([
            $this->admin->id,
            $this->user->id
        ]);
    }

    /**
     * Reset the migrations
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    protected function withAutentification($user)
    {
        $this->actingAs($user);
        $this->withMiddleware();
        session()->regenerateToken();
        $this->withHeader('X-CSRF-TOKEN', csrf_token());
    }

    protected function  generateUserData($user)
    {
        $data = [
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'admin' => (bool)$user->admin,
        ];

        return $data;
    }

    protected function createAdmin()
    {
        $adminUser = factory(User::class)->create();
        $adminUser->admin = 1;
        $adminUser->save();

        return $adminUser;
    }
}
