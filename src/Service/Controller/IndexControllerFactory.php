<?php declare(strict_types=1);

namespace ItemCopy\Service\Controller;

use Interop\Container\ContainerInterface;
use ItemCopy\Controller\IndexController;
use Laminas\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): IndexController
    {
        return new IndexController($container->get('Omeka\ApiManager'));
    }
}
