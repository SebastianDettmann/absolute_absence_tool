<?php

namespace Tests\Unit;

use App\Access;
use Tests\TestCase;

class AccessTest extends TestCase
{
    /** @test */
    public function save_any_reason_in_db()
    {
        $access = factory(Access::class)->create();
        $this->assertDatabaseHas('accesses', $access->getAttributes());
    }
}
