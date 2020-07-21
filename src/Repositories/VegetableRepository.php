<?php
declare(strict_types=1);
namespace PurpleHexagon\Repositories;

use Medoo\Medoo;

/**
 * Gateway to vegetables table
 *
 * -------------------------------------------------------------
 * Schema:
 * -------------------------------------------------------------
 * id
 * name
 * description
 * classification
 * edible
 * --------------------------------------------------------------
 *
 * TODO: Decide if this service should hydrate a Vegetable Object rather than return data as array
 * Class VegetableRepository
 * @package PurpleHexagon\services
 */
class VegetableRepository
{
    /**
     * @var Medoo
     */
    protected Medoo $db;

    /**
     * VegetableRepository constructor.
     * @param Medoo $db
     */
    public function __construct(Medoo $db)
    {
        $this->db = $db;
    }

    /**
     * @return array|bool
     */
    public function select()
    {
        return $this->db->select("vegetables", [
            "id",
            "name",
            "description",
            "classification",
            "edible",
        ]);
    }
}
