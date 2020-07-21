<?php
declare(strict_types=1);
namespace PurpleHexagon\Services;

use Faker\Factory as FakerFactory;
use Faker\Generator;
use Medoo\Medoo;

/**
 * Class Seeder
 * @package PurpleHexagon\Services
 */
class Seeder
{
    /**
     * @var Medoo
     */
    protected Medoo $db;

    /**
     * @var Generator
     */
    protected Generator $faker;

    /**
     * Seeder constructor.
     * @param Medoo $db
     */
    public function __construct(Medoo $db)
    {
        $this->db = $db;
        $this->faker = FakerFactory::create();
    }

    /**
     * Seed vegetables table
     */
    public function seedVegetables()
    {
        $this->db->insert("vegetables", [
            "name" => $this->faker->name,
            "classification" => $this->faker->randomLetter,
            "description" => $this->faker->paragraph
        ]);
    }
}
