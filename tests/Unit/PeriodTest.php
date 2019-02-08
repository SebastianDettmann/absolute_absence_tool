<?php

namespace Tests\Unit;

use App\Period;
use App\Reason;
use App\User;
use Tests\TestCase;

class PeriodTest extends TestCase
{
    /** @test */
    public function save_any_period_in_db()
    {
        $period = factory(Period::class)->create();
        $this->assertDatabaseHas('periods', $period->getAttributes());
    }

    /** @test */
    public function period_reason_relationship()
    {
        $reason = factory(Reason::class)->create();
        $period = factory(Period::class)->make();
        $period->reason()->associate($reason)->save();

        $this->assertEquals($period->reason, $reason);
    }

    /** @test */
    public function period_user_relationship()
    {
        $user = factory(User::class)->create();
        $period = factory(Period::class)->make();
        $period->user()->associate($user)->save();

        $this->assertEquals($period->user, $user);
    }
}
