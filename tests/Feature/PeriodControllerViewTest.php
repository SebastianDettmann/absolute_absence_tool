<?php

namespace Tests\Feature;

use Tests\TestCase;

class PeriodControllerViewTest extends TestCase
{
    /** @test */
    public function can_see_period_index()
    {
        $this->withAutentification($this->user);

        $this->get(route('period.index'))->assertSee(__('Meine Abwesenheit'));
        $this->get(route('period.index'))->assertViewHasAll([
            'periods_year_now_future',
            'periods_year_now_current',
            'periods_year_now_past',
            'reasons',
            'calendar',
        ]);
    }

    /** @test */
    public function can_see_period_index_all()
    {
        $this->withAutentification($this->user);

        $this->get(route('period.indexall'))->assertSee(__('Im Büro?'));
        $this->get(route('period.indexall'))->assertViewHasAll([
            'reasons',
            'calendar',
        ]);
    }
}
