<?php

use Medoo\Medoo;
use Prophecy\Prophecy\ObjectProphecy;
use PurpleHexagon\Repositories\VegetableRepository;

/**
 * Class VegetableRepositoryTest
 */
class VegetableRepositoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var VegetableRepository
     */
    protected VegetableRepository $service;

    /**
     * @var ObjectProphecy
     */
    protected ObjectProphecy $db;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->db = $this->prophesize(Medoo::class);
        $this->service = new VegetableRepository($this->db->reveal());
        parent::setUp();
    }

    /**
     * Given an instance of VegetableRepository
     * When select is called
     * Then it should return the correct results
     */
    public function testSelectSuccess()
    {
        $this->db->select("vegetables", Prophecy\Argument::any())->willReturn(['name' => 'test']);

        $result = $this->service->select();

        $this->assertEquals(['name' => 'test'], $result);
    }
}