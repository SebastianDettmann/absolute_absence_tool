<?php

use App\Period;
use App\Reason;
use Illuminate\Database\Seeder;

class PeriodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Period::flushEventListeners();

        foreach (Reason::get(['id']) as $reason_id) {
            factory(Period::class)->create([
                'reason_id' => $reason_id,
            ]);
        }
    }
}
