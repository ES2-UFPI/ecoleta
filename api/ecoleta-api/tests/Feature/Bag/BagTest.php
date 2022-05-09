<?php

namespace Tests\Feature\Bag;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BagTest extends TestCase
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
     * @grup Bag
     */
    public function cadastrarSacolaDeDescarte()
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
    }

    /**
     * @test
     * @grup Bag
     */
    public function cadastrarSacolaDeDescarteSemCliente()
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
                // 'user_id' => 1,
                'collect_point_id' => 1,
                'item' => [1],
                'quantity' => [10],
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }

    /**
     * @test
     * @grup Bag
     */
    public function cadastrarSacolaDeDescarteSemPontoDeColeta()
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
                // 'collect_point_id' => 1,
                'item' => [1],
                'quantity' => [10],
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }

    /**
     * @test
     * @grup Bag
     */
    public function cadastrarSacolaDeDescarteSemItemDoPontoDeColeta()
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
                // 'item' => [1],
                'quantity' => [10],
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }

    /**
     * @test
     * @grup Bag
     */
    public function cadastrarSacolaDeDescarteSemQuantidadeDosItensDoPontoDeColeta()
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
                // 'quantity' => [10],
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }

    /**
     * @test
     * @grup Bag
     */
    public function finalizarSacolaDeDescarte()
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
    }

    /**
     * @test
     * @grup Bag
     */
    public function setarFalsoNaFinalizacaoDaSacolaDeDescarte()
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
                'discarded' => false
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(404)
            ->assertJsonStructure(['success', 'message']);
    }

    /**
     * @test
     * @grup Bag
     */
    public function deletarSacolaDeDescarte()
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

        $this->delete(
            'api/admin/bag/1',
            [],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    /**
     * @test
     * @grup Bag
     */
    public function deletarSacolaDeDescarteComSacolaFinalizada()
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

        $this->delete(
            'api/admin/bag/1',
            [],
            ['Accept' => 'application/json']
        )
            ->assertStatus(404)
            ->assertJsonStructure(['success', 'message']);
    }
}
