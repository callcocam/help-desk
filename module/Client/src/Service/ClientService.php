<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 17/04/2018
 * Time: 00:02
 */

namespace Client\Service;


use Core\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class ClientService extends AbstractService
{

    /**
     * AbstractService constructor.
     * @param EntityManager $em
     */
    public function __construct( EntityManager $em )
    {
        $this->em = $em;
        $this->entity = "Client\Entity\Client";
    }
    public function save( Array $data = [] )
    {
        $data['password'] = $this->encryptPassword($data['document'], $data['password']);
        return parent::save($data);
    }
}