<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 12/04/2018
 * Time: 17:09
 */

namespace Client\Controller;


use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;

class ClientController extends AbstractController
{

    /**
     * AbstractController constructor.
     * @param ContainerInterface $container
     */
    public function __construct( ContainerInterface $container )
    {
        $this->container = $container;
        $this->filter = "Client\Filter\ClientFilter";
        $this->entity = "Client\Entity\Client";
        $this->service = "Client\Service\ClientService";
    }
}