<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Auth\Adapter;


use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;

use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as Adapter;

class AuthenticationFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     *
     * @return object
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		// The status field value of an account is not equal to "compromised"

		$dbAthenticate = new AuthenticationService();
		$dbAthenticate->setStorage(new AuthStorage());
        $authenticationService = $container->get('Zend\Authentication\AuthenticationService');
        $adapter = $authenticationService->getAdapter();
		$dbAthenticate->setAdapter($adapter);

		return new Authentication($dbAthenticate);
	}
}