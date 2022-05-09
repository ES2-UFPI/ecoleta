<?php

namespace Tests\Feature\CollectItem;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollectionItemTest extends TestCase
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
     * @grup CollectionItem
     */
    public function cadastrarItemNoPontoDeColeta()
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
    }

    /**
     * @test
     * @grup CollectionItem
     */
    public function cadastrarItemNoPontoDeColetaSemPontoDeColeta()
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
                // 'collect_point_id' => 1,
                'title' => 'Lixo Eletrônico'
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }

    /**
     * @test
     * @grup CollectionItem
     */
    public function cadastrarItemNoPontoDeColetaSemTitulo()
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
                // 'title' => 'Lixo Eletrônico'
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }

    /**
     * @test
     * @grup CollectionItem
     */
    public function editarItemNoPontoDeColeta()
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

        $this->put(
            'api/admin/collectionItem/1',
            [
                'collect_point_id' => 1,
                'title' => 'Lixo Eletrônico'
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    /**
     * @test
     * @grup CollectionItem
     */
    public function editarItemNoPontoDeColetaSemPontoDeColeta()
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

        $this->put(
            'api/admin/collectionItem/1',
            [
                // 'collect_point_id' => 1,
                'title' => 'Lixo Eletrônico'
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    /**
     * @test
     * @grup CollectionItem
     */
    public function editarItemNoPontoDeColetaSemTitulo()
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

        $this->put(
            'api/admin/collectionItem/1',
            [
                'collect_point_id' => 1,
                // 'title' => 'Lixo Eletrônico'
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }

    /**
     * @test
     * @grup CollectionItem
     */
    public function deletarItemNoPontoDeColeta()
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

        $this->delete(
            'api/admin/collectionItem/1',
            [],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    /**
     * @test
     * @grup CollectionItem
     */
    public function deletarItemNoPontoDeColetaInexistente()
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

        $this->delete(
            'api/admin/collectionItem/2',
            [],
            ['Accept' => 'application/json']
        )
            ->assertStatus(404)
            ->assertJsonStructure(['success', 'message']);
    }
}
