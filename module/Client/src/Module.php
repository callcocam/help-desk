<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */
namespace Client;

use Client\Adapter\Authentication;
use Client\Adapter\AuthenticationFactory;
use Interop\Container\ContainerInterface;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {

        return [
            'factories'=>[
                'Zend\Authentication\AuthenticationService' => function (ContainerInterface $serviceManager) {
                    // If you are using DoctrineORMModule:
                    return $serviceManager->get('doctrine.authenticationservice.orm_cient');
                },
                Authentication::class =>AuthenticationFactory::class,

            ]

        ];
    }
}
