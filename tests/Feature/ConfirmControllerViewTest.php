<?php

namespace Tests\Feature;

use Tests\TestCase;

class ConfirmControllerViewTest extends TestCase
{
    /** @test */
    public function admin_can_see_confirm_index()
    {
        $this->withAutentification($this->admin);

        $this->get(route('confirm.index'))->assertSee(__('Zeitraum bestätigen'));
    }
}
