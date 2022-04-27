<?php

namespace Tests\Feature\Region;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegionTest extends TestCase
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
     * @grup Region
     */
    public function cadastrarRegiao()
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
    }

    /**
     * @test
     * @grup Region
     */
    public function cadastrarRegiaoSemCidade()
    {
        $this->post(
            'api/admin/region',
            [
                // 'city_id' => 883,
                'title' => 'Zona Norte'
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }

    /**
     * @test
     * @grup Region
     */
    public function cadastrarRegiaoSemTitulo()
    {
        $this->post(
            'api/admin/region',
            [
                'city_id' => 883,
                // 'title' => 'Zona Norte'
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }

    /**
     * @test
     * @grup Region
     */
    public function editarRegiao()
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
            'api/admin/region/1',
            [
                'city_id' => 883,
                'title' => 'Zona Sua'
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    /**
     * @test
     * @grup Region
     */
    public function editarRegiaoSemCidade()
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
            'api/admin/region/1',
            [
                'title' => 'Zona Sua'
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    /**
     * @test
     * @grup Region
     */
    public function editarRegiaoSemTitulo()
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
            'api/admin/region/1',
            [
                'city_id' => 883,
                // 'title' => 'Zona Sua'
            ],
            ['Accept' => 'application/json']
        )
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }

    /**
     * @test
     * @grup Region
     */
    public function ExcluirRegiao()
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
            'api/admin/region/1',
            [],
            ['Accept' => 'application/json']
        )
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    /**
     * @test
     * @grup Region
     */
    public function ExcluirRegiaoInexistente()
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
            'api/admin/region/2',
            [],
            ['Accept' => 'application/json']
        )
            ->assertStatus(404)
            ->assertJsonStructure(['success', 'message']);
    }
}
