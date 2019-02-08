<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class UserControllerViewTest extends TestCase
{
    /** @test */
    public function admin_can_see_user_index()
    {
        $this->withAutentification($this->admin);

        $this->get(route('user.index'))
            ->assertSee(__('Verwaltung: Alle User'))
            ->assertViewHas('users');
    }

    /** @test */
    public function admin_can_see_user_create()
    {
        $this->withAutentification($this->admin);

        $this->get(route('user.create'))
            ->assertSee(__('User anlegen'))
            ->assertViewHas('accesses');
    }

    /** @test */
    public function admin_can_see_user_edit()
    {
        $this->withAutentification($this->admin);
        $user = User::first();

        $this->get(route('user.edit', [$user->id]))->assertSee(__('User bearbeiten'));
        $this->get(route('user.edit', [$user->id]))->assertViewHas('user');
    }

    /** @test */
    public function default_user_can_see_default_user_edit()
    {
        $this->withAutentification($this->user);
        $user = auth()->user();

        $this->get(route('user.edit', [$user->id]))->assertSee(__('User bearbeiten'));
        $this->get(route('user.edit', [$user->id]))->assertViewHas('user');
    }
}
