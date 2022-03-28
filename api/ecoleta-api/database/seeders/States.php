<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class States extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::firstOrCreate( [
            'name'=>'Acre',
            'code'=>'AC'
        ] );

        State::firstOrCreate( [
            'name'=>'Alagoas',
            'code'=>'AL'
        ] );

        State::firstOrCreate( [
            'name'=>'Amapá',
            'code'=>'AP'
        ] );

        State::firstOrCreate( [
            'name'=>'Amazonas',
            'code'=>'AM'
        ] );

        State::firstOrCreate( [
            'name'=>'Bahia',
            'code'=>'BA'
        ] );

        State::firstOrCreate( [
            'name'=>'Ceará',
            'code'=>'CE'
        ] );

        State::firstOrCreate( [
            'name'=>'Distrito Federal',
            'code'=>'DF'
        ] );

        State::firstOrCreate( [
            'name'=>'Espírito Santo',
            'code'=>'ES'
        ] );

        State::firstOrCreate( [
            'name'=>'Goiás',
            'code'=>'GO'
        ] );

        State::firstOrCreate( [
            'name'=>'Maranhão',
            'code'=>'MA'
        ] );

        State::firstOrCreate( [
            'name'=>'Mato Grosso',
            'code'=>'MT'
        ] );

        State::firstOrCreate( [
            'name'=>'Mato Grosso do Sul',
            'code'=>'MS'
        ] );

        State::firstOrCreate( [
            'name'=>'Minas Gerais',
            'code'=>'MG'
        ] );

        State::firstOrCreate( [
            'name'=>'Pará',
            'code'=>'PA'
        ] );

        State::firstOrCreate( [
            'name'=>'Paraíba',
            'code'=>'PB'
        ] );

        State::firstOrCreate( [
            'name'=>'Paraná',
            'code'=>'PR'
        ] );

        State::firstOrCreate( [
            'name'=>'Pernambuco',
            'code'=>'PE'
        ] );

        State::firstOrCreate( [
            'name'=>'Piauí',
            'code'=>'PI'
        ] );

        State::firstOrCreate( [
            'name'=>'Rio de Janeiro',
            'code'=>'RJ'
        ] );

        State::firstOrCreate( [
            'name'=>'Rio Grande do Norte',
            'code'=>'RN'
        ] );

        State::firstOrCreate( [
            'name'=>'Rio Grande do Sul',
            'code'=>'RS'
        ] );

        State::firstOrCreate( [
            'name'=>'Rondônia',
            'code'=>'RO'
        ] );

        State::firstOrCreate( [
            'name'=>'Roraima',
            'code'=>'RR'
        ] );

        State::firstOrCreate( [
            'name'=>'Santa Catarina',
            'code'=>'SC'
        ] );

        State::firstOrCreate( [
            'name'=>'São Paulo',
            'code'=>'SP'
        ] );

        State::firstOrCreate( [
            'name'=>'Sergipe',
            'code'=>'SE'
        ] );

        State::firstOrCreate( [
            'name'=>'Tocantins',
            'code'=>'TO'
        ] );
    }
}
