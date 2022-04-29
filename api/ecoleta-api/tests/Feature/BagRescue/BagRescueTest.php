<?php

namespace Tests\Feature\BagRescue;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BagRescueTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed([
            'States',
            'Cities',
            'Client',
            'Company',
        ]);
    }

/**
     * @test
     * @group BagRescue
     */
    public function erroCadastrarResgateDeSacolaPendenteSemEmpresa()
    {
        $this->post(
            'api/admin/region',
            [
                'city_id' => 883,
                'title' => 'Zona Norte'
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        $this->post(
            'api/admin/collect_point',
            [
                'region_id' => 1,
                'title' => 'Mercado do Sr. João'
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        $this->post(
            'api/admin/collectionItem',
            [
                'collect_point_id' => 1,
                'title' => 'Lixo Eletrônico'
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        $this->post(
            'api/admin/bag',
            [
                'user_id' => 1,
                'collect_point_id' => 1,
                'item' => [1],
                'quantity' => [10],
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        $this->put(
            'api/admin/bag/1',
            [
                'discarded' => true
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        $this->post(
            'api/admin/bag-rescue',
            [
                // 'company_id' => 2,
                'bag_id' => 1,
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }
}
