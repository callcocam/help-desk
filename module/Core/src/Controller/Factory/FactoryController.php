<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 12/04/2018
 * Time: 17:14
 */

namespace Core\Controller\Factory;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Factory\FactoryInterface;

class FactoryController implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ContainerException if any other error occurs
     */
    public function __invoke( ContainerInterface $container, $requestedName, array $options = null )
    {
        return new $requestedName($container);
    }
}