<?php
declare(strict_types=1);
namespace PurpleHexagon\Factories;

use ArrayObject;
use Medoo\Medoo;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use PurpleHexagon\Actions\GetVegetablesAction;
use PurpleHexagon\Commands\ListVegetablesCommand;
use PurpleHexagon\Services\Console;
use PurpleHexagon\Services\Http;
use PurpleHexagon\Repositories\VegetableRepository;
use PurpleHexagon\Services\Seeder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ContainerFactory
 * @package PurpleHexagon\factories
 */
class ContainerFactory
{
    /**
     * @param ArrayObject $config
     * @return ContainerInterface
     */
    public static function make(ArrayObject $config): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->registerForAutoconfiguration(Medoo::class);
        $containerBuilder->set(Medoo::class, DbFactory::make($config['db']));
        $containerBuilder->set(LoggerInterface::class, LoggerFactory::make());

        // TODO: Work out why autowiring isn't working, doesnt matter too much for now
        $containerBuilder->register(VegetableRepository::class, VegetableRepository::class)->addArgument(new Reference(Medoo::class));
        $containerBuilder->register(Seeder::class, Seeder::class)->addArgument(new Reference(Medoo::class));
        $containerBuilder->register(GetVegetablesAction::class, GetVegetablesAction::class)->addArgument(new Reference(VegetableRepository::class));
        $containerBuilder->register(ListVegetablesCommand::class, ListVegetablesCommand::class)->addArgument(new Reference(VegetableRepository::class));
        $containerBuilder->register(Http::class, Http::class)
            ->addArgument($containerBuilder)
            ->addArgument($config['routes'])
            ->addMethodCall('setLogger', [new Reference(LoggerInterface::class)]);

        $containerBuilder->register(Console::class, Console::class)->addArgument($containerBuilder);

        return $containerBuilder;
    }
}