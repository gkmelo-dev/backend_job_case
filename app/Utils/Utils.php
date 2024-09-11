<?php

namespace App\Utils;

class Utils
{
    public static function getValidUFs(): array
    {
        return [
            'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 
            'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 
            'SP', 'SE', 'TO',
        ];
    }

    public static function getValidEquipments(): array
    {
        return [
            'Módulo',
            'Inversor',
            'Microinversor',
            'Estrutura',
            'Cabo vermelho',
            'Cabo preto',
            'String Box',
            'Cabo Tronco',
            'Endcap'
        ];
    }
}
