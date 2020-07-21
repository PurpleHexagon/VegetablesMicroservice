<?php
declare(strict_types=1);
namespace PurpleHexagon\Factories;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class LoggerFactory
 * @package PurpleHexagon\Factories
 */
class LoggerFactory
{
    /**
     * @return Logger
     */
    public static function make()
    {
        $logger = new Logger('name');
        $logger->pushHandler(new StreamHandler( 'app.log'));

        return $logger;
    }
}
