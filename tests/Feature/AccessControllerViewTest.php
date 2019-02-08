<?php

namespace Tests\Feature;

use App\Access;
use Tests\TestCase;

class AccessControllerViewTest extends TestCase
{
    /** @test */
    public function can_see_access_index()
    {
        $this->withAutentification($this->admin);

        $this->get(route('access.index'))->assertSee(__('Verwaltung: Alle Zugänge'));
        $this->get(route('access.index'))->assertViewHas('accesses');
    }

    /** @test */
    public function can_see_access_create()
    {
        $this->withAutentification($this->admin);

        $this->get(route('access.create'))->assertSee(__('Zugang anlegen'));
    }

    /** @test */
    public function can_see_access_edit()
    {
        $this->withAutentification($this->admin);
        $access = Access::first();

        $this->get(route('access.edit', [$access->id]))->assertSee(__('Zugang bearbeiten'));
        $this->get(route('access.edit', [$access->id]))->assertViewHas('access');
    }
}
