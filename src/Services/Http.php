<?php
declare(strict_types=1);
namespace PurpleHexagon\Services;

use Exception;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use PurpleHexagon\Exceptions\PublicHttpException;
use PurpleHexagon\Actions\GetVegetablesAction;
use function FastRoute\simpleDispatcher;

/**
 * Serve HTTP responses
 *
 * Class Http
 * @package PurpleHexagon\services
 */
class Http
{
    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * @var array
     */
    protected array $routeConfig;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * Http constructor.
     * @param ContainerInterface $container
     * @param array $routeConfig
     */
    public function __construct(ContainerInterface $container, array $routeConfig)
    {
        $this->container = $container;
        $this->routeConfig = $routeConfig;
    }

    /**
     * Defines routes and renders response
     */
    public function serve()
    {
        $dispatcher = $this->configure();

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $response = new JsonResponse(['message' => 'Not Found'], 404);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                $response = new JsonResponse(['message' => 'Not Found'], 405);
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                try {
                    $response = $handler($vars);
                } catch (PublicHttpException $e) {
                    $this->logger->error('Error occurred during HTTP response', ['stacktrace' => $e->getTrace(), 'message' => $e->getMessage()]);
                    $response = new JsonResponse(['message' => $e->getMessage()], 400);
                } catch (Exception $e) {
                    $response = new JsonResponse(['message' => 'An unknown error occurred'], 400);
                }

                break;
            default:
                $response = new JsonResponse(['message' => 'An unknown error occurred'], 400);
                break;
        }

        echo $response->getBody();
    }

    /**
     * Configure routes etc for HTTP
     *
     * @return Dispatcher
     */
    protected function configure(): Dispatcher
    {
        $routeConfig = $this->routeConfig;
        return simpleDispatcher(function(RouteCollector $r) use ($routeConfig) {
            // Define each route from config file and fetch handler if known by DI container
            foreach ($routeConfig as $route) {
                $handler = $route['handler'];

                if ($this->container->has($route['handler'])) {
                    $handler = $this->container->get(GetVegetablesAction::class);
                }

                $r->addRoute($route['method'], $route['route'], $handler);
            }
        });
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
