<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 16/04/2018
 * Time: 22:04
 */

namespace Auth\Service;


use Core\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class AuthService extends AbstractService
{

    /**
     * AbstractService constructor.
     * @param EntityManager $em
     */
    public function __construct( EntityManager $em )
    {
        $this->em = $em;
    }
}