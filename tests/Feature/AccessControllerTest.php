<?php

namespace Tests\Feature;

use App\Access;
use Tests\TestCase;

class AccessControllerTest extends TestCase
{
    /** @test */
    public function admin_can_access_all_controller_functions()
    {
        $this->withAutentification($this->admin);
        $access = factory(Access::class)->make();

        $this->get(route('access.index'))->assertStatus(200);
        $this->get(route('access.create'))->assertStatus(200);
        $this->followingRedirects()
            ->post(route('access.store'), $access->getAttributes())
            ->assertStatus(200);

        $access = factory(Access::class)->create();

        $this->get(route('access.edit', [$access->id]))->assertStatus(200);
        $this->followingRedirects()
            ->put(route('access.update', [$access->id]), factory(Access::class)->make()->getAttributes())
            ->assertStatus(200);
        $this->followingRedirects()
            ->delete(route('access.destroy', [$access->id]))
            ->assertStatus(200);
    }

    /** @test */
    public function user_cant_access_any_controller_functions()
    {
        $this->withAutentification($this->user);
        $access = factory(Access::class)->create();

        $this->get(route('access.index'))->assertStatus(404);
        $this->get(route('access.create'))->assertStatus(404);
        $this->post(route('access.store'), $access->getAttributes())->assertStatus(404);
        $this->get(route('access.edit', [$access->id]))->assertStatus(404);
        $this->put(route('access.update', [$access->id]), [])->assertStatus(404);
        $this->delete(route('access.destroy', [$access->id]))->assertStatus(404);
    }

    /** @test */
    public function can_store_access()
    {

        $this->withAutentification($this->admin);
        $data = factory(Access::class)->make()->getAttributes();

        $this->post(route('access.store'), $data);

        $this->assertDatabaseHas('accesses', $data);
    }

    /** @test */
    public function can_update_access()
    {

        $this->withAutentification($this->admin);
        $access = factory(Access::class)->create();
        $data = factory(Access::class)->make()->getAttributes();

        $this->put(route('access.update', [$access->id]), $data)->assertStatus(200);
        $this->assertDatabaseHas('accesses', $data);
    }

    /** @test */
    public function can_delete_access()
    {
        $this->withAutentification($this->admin);
        $access = factory(Access::class)->create();

        $this->delete(route('access.destroy', [$access->id]))->assertStatus(200);
        $this->assertDatabaseMissing('accesses', [
            'id' => $access->id
        ]);
    }
}
