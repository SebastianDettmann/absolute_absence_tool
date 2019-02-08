<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /** @test */
    public function admin_can_access_all_controller_functions()
    {
        $this->withAutentification($this->admin);
        $user = factory(User::class)->create();
        $data = $this->generateUserData(factory(User::class)->make());

        $this->get(route('user.index'))->assertStatus(200);
        $this->followingRedirects()
            ->post(route('user.store'), $data)
            ->assertStatus(200);
        $this->get(route('user.create'))->assertStatus(200);
        // removed show route, use edit route for showing user
        // $this->get(route('user.show', [$user->id]))->assertStatus(200);
        //server error, when updating unique DB email column with the same value, seams to be a problem with SQLlight test DB

        $data = $this->request_data_with_pw(factory(User::class)->make());

        $this->get(route('user.edit', [$user->id]))->assertStatus(200);
        $this->followingRedirects()
            ->put(route('user.update', [$user->id]), $data)
            ->assertStatus(200);
        $this->followingRedirects()
            ->delete(route('user.destroy' , [$user->id]))
            ->assertStatus(200);
    }


    /** @test */
    public function default_user_can_access_default_user_update_edit_controller_functions()
    {
        $this->withAutentification($this->user);
        $user = auth()->user();
        $data = $this->request_data_with_pw($user);

        // removed show route, use edit route for showing user
        // $this->get(route('user.show', [$user->id]))->assertStatus(200);
        $this->get(route('user.edit', [$user->id]))->assertStatus(200);
        $this->followingRedirects()
            ->put(route('user.update', [$user->id]), $data)
            ->assertStatus(200);
    }

    /** @test */
    public function default_user_cant_access_other_user_edit_update_controller_functions()
    {
        $this->withAutentification($this->user);
        $user = factory(User::class)->create();
        $data = $this->request_data_with_pw(factory(User::class)->make());

        $this->get(route('user.edit', [$user->id]))->assertStatus(404);
        $this->put(route('user.update', [$user->id]), $data)->assertStatus(404);
    }

    /** @test */
    public function default_user_cant_access_index_store_create_destroy_controller_functions()
    {
        $this->withAutentification($this->user);
        $user = factory(User::class)->create();

        $this->get(route('user.index'))->assertStatus(404);
        $this->post(route('user.store'))->assertStatus(404);
        $this->get(route('user.create'))->assertStatus(404);
        $this->delete(route('user.destroy' , [$user->id]))->assertStatus(404);
    }

    /** @test */
    public function admin_can_store_user()
    {
        $this->withAutentification($this->admin);
        $data = $this->generateUserData(factory(User::class)->make());

        $this->post(route('user.store'), $data);

        $this->dbAssertion($data);
    }

    /** @test */
    public function admin_can_delete_user()
    {
        $this->withAutentification($this->admin);
        $user = factory(User::class)->create();

        $this->delete(route('user.destroy' , [$user->id]))->assertStatus(200);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }

    /** @test */
    public function user_can_update_self()
    {
        $this->withAutentification($this->user);
        $this->can_update_user(auth()->user());
    }

    /** @test */
    public function admin_can_update_user()
    {
        $this->withAutentification($this->admin);
        $user = factory(User::class)->create();
        $this->can_update_user($user);
    }

    private function dbAssertion(array $data)
    {
        $this->assertDatabaseHas('users', [
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
        ]);
    }

    private function can_update_user($user)
    {
        $this->withoutExceptionHandling();

        $data = $this->request_data_with_pw($user);

        $this->put(route('user.update', [$user->id]), $data)->assertStatus(200);
        $this->dbAssertion($data);
    }

    private function request_data_with_pw($user)
    {
        $data = $this->generateUserData($user);
        # pw are default from User factory
        $passwords = [
            'password_old' => 'Qwertz123',
            'password' => 'Qwertz123456',
            'password_confirmation' => 'Qwertz123456',
        ];
        $data = array_merge($data, $passwords);

        return $data;
    }
}
