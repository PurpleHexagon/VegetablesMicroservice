<?php
declare(strict_types=1);
namespace PurpleHexagon\Factories;

use Medoo\Medoo;

/**
 * Class DbFactory
 * @package PurpleHexagon\factories
 */
class DbFactory
{
    /**
     * @param array $dbConfig
     * @return Medoo
     */
    public static function make(array $dbConfig): Medoo
    {
        return new Medoo($dbConfig);
    }
}
