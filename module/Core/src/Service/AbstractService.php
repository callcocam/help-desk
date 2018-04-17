<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 16/04/2018
 * Time: 18:38
 */

namespace Core\Service;


use Admin\Entity\Empresa;
use Auth\Entity\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Zend\Crypt\Key\Derivation\Pbkdf2;
use Zend\Hydrator\ClassMethods;

abstract class AbstractService
{
    protected $em;
    protected $entity;

    /**
     * @var array
     */
    protected $Result = [
        'result' => FALSE,
        'type' => "danger",
        'msg' => "",
        'entity' => null
    ];

    /**
     * AbstractService constructor.
     * @param EntityManager $em
     */
    abstract public function __construct( EntityManager $em );

    /**
     * @param array $data
     * @return array
     */
    public function save( Array $data = [] )
    {

        if (isset($data['empresa'])) {
            if (!(int)$data['empresa']) {
                $data['empresa'] = 1;
            }
            $data['empresa'] = $this->em->getReference(Empresa::class, $data['empresa']);
        }
        if (isset($data['author'])) {
            $data['author'] = $this->em->getReference(User::class, $data['author']);
        }

        try {
            if (isset($data['id']) && $data['id']) {
                $d = $this->em->getRepository($this->entity)->find($data['id']);
                if ($d) {
                    $entity = $this->em->getReference($this->entity, $data['id']);
                    $hydrate = new ClassMethods();
                    $hydrate->hydrate($data, $entity);
                } else {
                    $entity = new $this->entity($data);
                }
                $this->em->persist($entity);
                return $this->getResult($entity, $data['id'], "Registro atualizado com sucesso");

            } else {
                $entity = new $this->entity($data);
                $this->em->persist($entity);
                return $this->getResult($entity, 1, "Registro cadastrado com sucesso");
            }


        } catch (ORMException $ORMException) {
            //$this->em->getConfiguration()->setSQLLogger(new EchoSQLLogger());
            $this->Result['msg'] = $ORMException->getMessage();
        } catch (UniqueConstraintViolationException $violationException) {
            $this->Result['msg'] = $violationException->getMessage();
        }

        return $this->Result;
    }

    public function remove( Array $data = array() )
    {
        $entity = $this->em->getRepository($this->entity)->findOneBy($data);
        if ($entity) {
            $this->em->remove($entity);
            return $this->getResult($entity, 1, "Registro excluido com sucesso");
        }
        $this->Result['msg'] = "Não foi possivel excluir o registro";
        return $this->Result;

    }

    public function state( $id, $valor )
    {
        //atualiza o valor pago no cabecalho da venda
        $qb = $this->em->createQueryBuilder();
        $q = $qb->update($this->entity, 'u')
            ->set('u.status', '?1')
            ->where("u.id= ?2")
            ->setParameter(1, $valor)
            ->setParameter(2, $id)
            ->getQuery();
        $p = $q->execute();
        return $p;

    }

    protected function getResult( $entity, $result = 1, $message = "Registro cadastrado com sucesso" )
    {
        try {

            $this->em->flush();
            $this->Result = [
                'result' => $result,
                'type' => "success",
                'msg' => $message,
                'entity' => $entity
            ];
            return $this->Result;
        } catch (ORMException $ORMException) {
            //$this->em->getConfiguration()->setSQLLogger(new EchoSQLLogger());
            $this->Result['type'] = 'error';
            $this->Result['result'] = false;
            $this->Result['msg'] = $ORMException->getMessage();
            return $this->Result;
        } catch (UniqueConstraintViolationException $violationException) {
            $this->Result['type'] = 'error';
            $this->Result['result'] = false;
            $this->Result['msg'] = $violationException->getMessage();
            return $this->Result;
        }

    }

    public function encryptPassword( $email, $password )
    {
        return base64_encode(Pbkdf2::calc('sha256', $password, $email, 10000, strlen($password) * 2));
    }
}