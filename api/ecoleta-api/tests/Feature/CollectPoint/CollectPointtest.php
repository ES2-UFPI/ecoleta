<?php

namespace Tests\Feature\CollectPoint;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollectPointtest extends TestCase
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
     * @grup CollectPoint
     */
    public function cadastrarPontoDeColeta()
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
                'title' => 'Mercado do Sr. João',
                'latitude' => '123456',
                'longitude' => '123456',
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    /**
     * @test
     * @grup CollectPoint
     */
    public function cadastrarPontoDeColetaSemRegiao()
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
                // 'region_id' => 1,
                'title' => 'Mercado do Sr. João',
                'latitude' => '123456',
                'longitude' => '123456',
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }

    /**
     * @test
     * @grup CollectPoint
     */
    public function cadastrarPontoDeColetaSemTitulo()
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
                // 'title' => 'Mercado do Sr. João',
                'latitude' => '123456',
                'longitude' => '123456',
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }

    /**
     * @test
     * @grup CollectPoint
     */
    public function editarPontoDeColeta()
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

        $this->put(
            'api/admin/collect_point/1',
            [
                'region_id' => 1,
                'title' => 'Mercado do Sr. João',
                'latitude' => '123456',
                'longitude' => '123456',
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    /**
     * @test
     * @grup CollectPoint
     */
    public function editarPontoDeColetaSemRegiao()
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

        $this->put(
            'api/admin/collect_point/1',
            [
                // 'region_id' => 1,
                'title' => 'Mercado do Sr. João',
                'latitude' => '123456',
                'longitude' => '123456',
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    /**
     * @test
     * @grup CollectPoint
     */
    public function editarPontoDeColetaSemTitulo()
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

        $this->put(
            'api/admin/collect_point/1',
            [
                'region_id' => 1,
                // 'title' => 'Mercado do Sr. João',
                'latitude' => '123456',
                'longitude' => '123456',
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }

    /**
     * @test
     * @grup CollectPoint
     */
    public function excluirPontoDeColeta()
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

        $this->delete(
            'api/admin/collect_point/1',
            [],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    /**
     * @test
     * @grup CollectPoint
     */
    public function excluirPontoDeColetaInexistente()
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

        $this->delete(
            'api/admin/collect_point/2',
            [],
            ['Accept' => 'application/json']
        )
            ->assertStatus(404)
            ->assertJsonStructure(['success', 'message']);
    }
}
