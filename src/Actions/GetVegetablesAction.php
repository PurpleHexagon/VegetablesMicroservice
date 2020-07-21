<?php
declare(strict_types=1);
namespace PurpleHexagon\Http;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use PurpleHexagon\Exceptions\PublicHttpException;
use PurpleHexagon\Repositories\VegetableRepository;

/**
 * Invokable Action to return JSON response listing all vegetables
 *
 * Class GetVegetablesAction
 * @package PurpleHexagon\http
 */
class GetVegetablesAction
{
    /**
     * @var VegetableRepository
     */
    protected VegetableRepository $vegetablesRepository;

    /**
     * GetVegetablesAction constructor.
     * @param VegetableRepository $vegetablesRepository
     */
    public function __construct(VegetableRepository $vegetablesRepository)
    {
        $this->vegetablesRepository = $vegetablesRepository;
    }

    /**
     * GET /
     *
     * @return ResponseInterface
     */
    public function __invoke(): ResponseInterface {
        $vegResults = $this->vegetablesRepository->select();

        if ($vegResults === false) {
            throw new PublicHttpException('An error occurred whilst trying to list vegetables');
        }

        return new JsonResponse($vegResults);
    }
}