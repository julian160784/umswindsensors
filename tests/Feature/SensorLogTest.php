<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SensorLogTest extends TestCase
{
    protected function user()
    {
        return User::first();
    }

    public function testStore()
    {
        $response = $this->actingAs($this->user(), 'api')
            ->json('POST', '/api/sensorLog', [
                'data1' => 100,
                'data2' => 300
            ]);

        $response->assertJson(['success' => true]);
    }
}
