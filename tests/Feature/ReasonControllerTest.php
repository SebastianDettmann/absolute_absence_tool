<?php

namespace Tests\Feature;

use App\Period;
use App\Reason;
use Tests\TestCase;

class ReasonControllerTest extends TestCase
{
    /** @test */
    public function admin_can_access_all_controller_functions()
    {
        $this->withAutentification($this->admin);
        $reason = factory(Reason::class)->make();

        $this->get(route('reason.index'))->assertStatus(200);
        $this->get(route('reason.create'))->assertStatus(200);
        $this->followingRedirects()
            ->post(route('reason.store'), $reason->getAttributes())
            ->assertStatus(200);

        $reason = factory(Reason::class)->create();

        $this->get(route('reason.edit', [$reason->id]))->assertStatus(200);
        $this->followingRedirects()
            ->put(route('reason.update', [$reason->id]), factory(Reason::class)->make()->getAttributes())
            ->assertStatus(200);
        $this->followingRedirects()
            ->delete(route('reason.destroy' , [$reason->id]))
            ->assertStatus(200);
    }

    /** @test */
    public function user_cant_access_any_controller_functions()
    {
        $this->withAutentification($this->user);
        $reason = factory(Reason::class)->create();

        $this->get(route('reason.index'))->assertStatus(404);
        $this->get(route('reason.create'))->assertStatus(404);
        $this->post(route('reason.store'), $reason->getAttributes())->assertStatus(404);
        $this->get(route('reason.edit', [$reason->id]))->assertStatus(404);
        $this->put(route('reason.update', [$reason->id]), [])->assertStatus(404);
        $this->delete(route('reason.destroy' , [$reason->id]))->assertStatus(404);
    }

    /** @test */
    public function can_store_reason()
    {

        $this->withAutentification($this->admin);
        $data = factory(Reason::class)->make()->getAttributes();

        $this->post(route('reason.store'), $data);
        $data["has_to_confirm"] = $data["has_to_confirm"] ? '1' : '0';
        $this->assertDatabaseHas('reasons', $data);
    }

    # /** @test */
    public function can_update_reason()
    {

        $this->withAutentification($this->admin);
        $reason = factory(Reason::class)->create();
        $data = factory(Reason::class)->make()->getAttributes();

        $this->put(route('reason.update', [$reason->id]), $data)->assertStatus(200);
        $data["has_to_confirm"] = $data["has_to_confirm"] ? '1' : '0';
        $this->assertDatabaseHas('reasons', $data);
    }

    /** @test */
    public function can_delete_reason()
    {
        $this->withAutentification($this->admin);
        $reason = factory(Reason::class)->create();

        $this->delete(route('reason.destroy' , [$reason->id]))->assertStatus(200);
        $this->assertDatabaseMissing('reasons', [
            'id' => $reason->id
        ]);
    }

    /** @test */
    public function cant_delete_reason_having_periods()
    {
        $this->withAutentification($this->admin);
        $reason = factory(Reason::class)->create();
        $period = factory(Period::class)->create([
            'reason_id' => $reason->id,
        ]);

        $this->delete(route('reason.destroy', [$reason->id]))
            ->assertStatus(200)
            ->assertSee(trans('alerts.save_failed'));
        $this->assertDatabaseHas('reasons', [
            'id' => $reason->id,
        ]);
    }
}
