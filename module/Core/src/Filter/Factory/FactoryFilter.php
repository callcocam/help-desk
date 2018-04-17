<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 12/04/2018
 * Time: 17:14
 */

namespace Core\Filter\Factory;


use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class FactoryFilter implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     */
    public function __invoke( ContainerInterface $container, $requestedName, array $options = null )
    {
        return new $requestedName($container);
    }

}