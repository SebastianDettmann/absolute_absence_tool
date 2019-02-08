<?php

namespace Tests\Unit;

use App\Reason;
use Tests\TestCase;

class ReasonTest extends TestCase
{
    /** @test */
    public function save_a_reason_in_db()
    {
        $data = [
            'title' => 'Test Urlaub',
            'description' => 'Erholungsurlaub',
            'hex_color' => '#123456',
            'has_to_confirm' => true,
        ];

        $reason = Reason::create($data);
        $this->assertDatabaseHas('reasons', $reason->getAttributes());
    }

    /** @test */
    public function save_any_reason_in_db()
    {
        $reason = factory(Reason::class)->create();
        $this->assertDatabaseHas('reasons', $reason->getAttributes());
    }
}
