<?php
declare(strict_types=1);
namespace PurpleHexagon\Services;

use Clue\React\Stdio\Stdio;
use Faker\Factory as FakerFactory;
use Psr\Container\ContainerInterface;
use PurpleHexagon\Commands\ListVegetablesCommand;
use React\EventLoop\Factory;

/**
 * Handles IO from command line
 *
 * Class Console
 * @package PurpleHexagon\services
 */
class Console
{
    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * Http constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Writes to console
     */
    public function run()
    {
        $loop = Factory::create();
        $stdio = new Stdio($loop);

        $stdio->write('Commands:' . PHP_EOL);

        $stdio->write(PHP_EOL);
        $stdio->write('---------------------------------------------' . PHP_EOL);
        $stdio->write('veg-list: Lists all vegetables in the db' . PHP_EOL);
        $stdio->write('---------------------------------------------' . PHP_EOL);
        $stdio->write('veg-seed: Seed vegetables in the db' . PHP_EOL);
        $stdio->write('---------------------------------------------' . PHP_EOL);
        $stdio->write('quit: Quit the command prompt' . PHP_EOL);
        $stdio->write('---------------------------------------------' . PHP_EOL);
        $stdio->write(PHP_EOL);

        $stdio->setPrompt('Run command: > ');

        /*** @var $listVegCommand ListVegetablesCommand */
        $listVegCommand = $this->container->get(ListVegetablesCommand::class);


        /*** @var $seeder Seeder */
        $seeder = $this->container->get(Seeder::class);


        $stdio->on('data', function ($line) use ($stdio, $seeder, $listVegCommand) {
            $line = rtrim($line, "\r\n");

            if ($line === 'quit') {
                $stdio->end();
            }

            if ($line === 'veg-list') {
                $listVegCommand->run($stdio, $line);
            } elseif ($line === 'veg-seed') {
                $seeder->seedVegetables();
            } else {
                $stdio->write("Command $line not found, try help, output or seed commands" . PHP_EOL);
            }

        });

        $loop->run();
    }
}