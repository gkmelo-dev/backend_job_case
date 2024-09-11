<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Utils\Utils;

class UtilsRoutesTest extends TestCase
{
    /**
     * Testa a rota que retorna as UFs válidas.
     *
     * @return void
     */
    public function testListValidUfs()
    {
        $response = $this->get('/api/valid-ufs');
    
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'ufs'
                 ])
                 ->assertJson([
                     'ufs' => Utils::getValidUFs()
                 ]);
    }
    
    /**
     * Testa a rota que retorna os equipamentos válidos.
     *
     * @return void
     */
    public function testListValidEquipments()
    {
        $response = $this->get('/api/valid-equipments');
    
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'equipments' // Verifica que existe uma chave `equipments`
                 ])
                 ->assertJson([
                    'equipments' => Utils::getValidEquipments()
                ]);
    }

    /**
     * Testa a rota que retorna os tipos de instalação válidos.
     *
     * @return void
     */
    public function testListValidInstallationTypes()
    {
        $response = $this->get('/api/valid-installation-types');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'installation_types'
                 ])
                 ->assertJson([
                    'installation_types' => Utils::getValidInstallationTypes()
                ]);
    }
}
