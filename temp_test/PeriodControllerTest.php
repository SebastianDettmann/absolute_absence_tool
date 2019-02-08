<?php

namespace Tests\Feature;

use App\Period;
use Carbon\Carbon;
use Tests\TestCase;

class PeriodControllerTest extends TestCase
{
    protected $timezone = 'Europe/Berlin';

    #/** @test */
    public function user_can_access_controller_functions()
    {
        $this->withAutentification($this->user);
        $period = factory(Period::class)->make(['user_id' => $this->user->id]);

        $this->get(route('period.index'))->assertStatus(200);
        $this->get(route('period.indexall'))->assertStatus(200);
        $this->followingRedirects()
            ->post(route('period.store'), $this->castToRequestAttributes($period))
            ->assertStatus(200);

        $period = factory(Period::class)->create();
        $this->user->periods()->save($period);

        $this->followingRedirects()
            ->delete(route('period.destroy' , [$period->id]))
            ->assertStatus(200);
    }

    #/** @test */
    public function can_store_period()
    {
        $this->withoutExceptionHandling();
        $this->withAutentification($this->user);
        $period = factory(Period::class)->make();
        $data = $period->getAttributes();
        $this->post(route('period.store'), $this->castToRequestAttributes($period));

        $this->assertDatabaseHas('periods', [
            'start' => $data['start'],
            'end' => $data['end']
        ]);
    }

    #/** @test */
    public function can_delete_period()
    {
        $this->withAutentification($this->user);
        $start = (rand(1, 30));
        $period = factory(Period::class)->create([
            'start' => Carbon::today()->addDays($start)->timezone($this->timezone)->toDateString(),
            'end' => Carbon::today()->addDays($start + rand(0, 30))->timezone($this->timezone)->toDateString(),
        ]);
        $this->user->periods()->save($period);

        $this->delete(route('period.destroy', [$period->id]))->assertStatus(200);
         $this->assertDatabaseMissing('periods', [
             'id' => $period->id
         ]);

    }

    #/** @test */
    public function cant_delete_period_lte_today()
    {
        $this->withAutentification($this->user);
        $end = (rand(1, 30));
        $period = factory(Period::class)->create([
            'start' => Carbon::today()->subDays($end + rand(0, 30))->timezone($this->timezone)->toDateString(),
            'end' => Carbon::today()->subDays($end)->timezone($this->timezone)->toDateString(),
        ]);
        $this->user->periods()->save($period);

        $this->delete(route('period.destroy', [$period->id]))
             ->assertStatus(200)
             ->assertSee(trans('alerts.save_failed'));
         $this->assertDatabaseHas('periods', [
             'id' => $period->id,
         ]);
    }

    private function castToRequestAttributes($period)
    {
        $data = $period->getAttributes();
        $data['start'] = Carbon::parse($data['start'])->timezone($this->timezone)->format('d.m.Y');
        $data['end'] = Carbon::parse($data['end'])->timezone($this->timezone)->format('d.m.Y');

        return $data;
    }
}
