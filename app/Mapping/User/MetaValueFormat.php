<?php

namespace App\Mapping\User;

use Yonna\Mapping\Mapping;

class MetaValueFormat extends Mapping
{

    const STRING = 'string';
    const INTEGER = 'integer';
    const FLOAT1 = 'float1';
    const FLOAT2 = 'float2';
    const FLOAT3 = 'float3';
    const DATE = 'date';
    const TIME = 'time';
    const DATETIME = 'datetime';

    public function __construct()
    {
        self::setLabel(self::STRING, 'String');
        self::setLabel(self::INTEGER, 'Integer');
        self::setLabel(self::FLOAT1, 'One decimal place');
        self::setLabel(self::FLOAT2, 'Two decimal places');
        self::setLabel(self::FLOAT3, 'Three decimal places');
        self::setLabel(self::DATE, 'Date');
        self::setLabel(self::TIME, 'Time');
        self::setLabel(self::DATETIME, 'Date and time');
    }

}