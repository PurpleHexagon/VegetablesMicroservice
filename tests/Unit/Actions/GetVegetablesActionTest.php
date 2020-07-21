<?php

use Psr\Http\Message\ResponseInterface;
use PurpleHexagon\Actions\GetVegetablesAction;
use PurpleHexagon\Exceptions\PublicHttpException;
use PurpleHexagon\Repositories\VegetableRepository;

/**
 * Class GetVegetablesActionTest
 */
class GetVegetablesActionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var GetVegetablesAction
     */
    protected GetVegetablesAction $action;
    /**
     * @var \Prophecy\Prophecy\ObjectProphecy
     */
    protected \Prophecy\Prophecy\ObjectProphecy $repo;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->repo = $this->prophesize(VegetableRepository::class);
        $this->action = new GetVegetablesAction($this->repo->reveal());
        parent::setUp();
    }

    /**
     * Given an instance of GetVegetablesAction
     * When it is invoked
     * Then it should return an instance implementing ResponseInterface
     */
    public function testActionShouldReturnAResponse()
    {
        $this->repo->select()->willReturn([]);
        $result = $this->action->__invoke();
        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    /**
     * Given an instance of GetVegetablesAction
     * When it is invoked
     * Then it should return the results from the repo select
     */
    public function testActionShouldReturnTheCorrectBody()
    {
        $this->repo->select()->willReturn(['test' => true]);
        $result = $this->action->__invoke();
        $this->assertEquals('{"test":true}', (string) $result->getBody());
    }

    /**
     * Given an instance of GetVegetablesAction
     * When it is invoked and result is false
     * Then it should throw an exception
     */
    public function testActionShouldThrowException()
    {
        $this->expectException(PublicHttpException::class);

        $this->repo->select()->willReturn(false);
        $this->action->__invoke();
    }
}