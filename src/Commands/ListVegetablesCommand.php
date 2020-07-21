<?php
declare(strict_types=1);
namespace PurpleHexagon\Commands;

use Clue\React\Stdio\Stdio;
use PurpleHexagon\Repositories\VegetableRepository;

class ListVegetablesCommand
{
    /**
     * @var VegetableRepository
     */
    protected VegetableRepository $vegetableRepository;

    /**
     * Console constructor.
     * @param VegetableRepository $vegetableRepository
     */
    public function __construct(VegetableRepository $vegetableRepository)
    {
        $this->vegetableRepository = $vegetableRepository;
    }

    /**
     * @param Stdio $stdio
     * @param string $line
     */
    public function run(Stdio $stdio, string $line)
    {
        $stdio->write('Results:: ' . PHP_EOL);

        $vegResults = $this->vegetableRepository->select();

        foreach ($vegResults as $vegResult) {
            $stdio->write('ID: ' . $vegResult['id'] . PHP_EOL);
            $stdio->write('Name: ' . $vegResult['name'] . PHP_EOL);
            $stdio->write('Desc: ' . $vegResult['description'] . PHP_EOL);
            $stdio->write('Classification: ' . $vegResult['classification'] . PHP_EOL);
            $stdio->write('Is Edible: ' . $vegResult['edible'] . PHP_EOL);
            $stdio->write(PHP_EOL);
        }
    }
}