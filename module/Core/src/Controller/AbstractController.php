<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Core\Controller;


use Core\Filter\AbstractFilter;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

abstract class AbstractController extends ApiController
{


    /**
     * AbstractController constructor.
     * @param ContainerInterface $container
     */


    /**
     * @param mixed $data
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function create( $data )
    {
        $this->apiResponse = [];
        if (!$data):
            $this->httpStatusCode = 401;
            return $this->createResponse();
        endif;
        if (is_string($this->service)):
            $this->getService();
        endif;
        if (is_string($this->filter)):
            $this->getFilter();
        endif;
        $this->save($data);
        $this->apiResponse = array_merge($this->args, $this->apiResponse);
        return $this->createResponse();
    }

    protected function save( $data )
    {
        /**
         * Pega o inputFilter Validate
         */
        $validate = $this->filter->getInputFilter();
        if (isset($data['status'])):
            if (is_array($data['status'])):
                $data['status'] = $data['status']['value'];
            endif;
        else:
            $data['status'] = '1';
        endif;
        // generate token if valid user
        $validate->setData($data);
        if ($validate->isValid()):
            //$this->args = array_merge($this->args,['msg'=>'Formulario Validado com success']);
            $this->args = array_merge($this->args, $this->service->save($data));
        else:
            $this->getMessages($validate->getMessages());
        endif;
    }

    /**
     * @param mixed $id
     * @return mixed
     */
    public function delete( $id )
    {
        return $this->createResponse();
    }

    /**
     * @param mixed $id
     * @return mixed
     */
    public function get( $id )
    {
        return $this->createResponse();
    }

    /**
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getList()
    {
        $this->repository = $this->getEm()->getRepository($this->entity)->QueryBuilder('p');
        $this->apiResponse = $this->repository->getPaginator();

        return $this->createResponse();
    }

    /**
     * @param mixed $id
     * @param mixed $data
     * @return mixed
     */
    public function update( $id, $data )
    {
        return $this->createResponse();
    }


    /**
     * @param mixed $entity
     * @return ApiController
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function setEntity( $entity )
    {
        $this->entity = $entity;
        if (!$this->repository) {
            $this->getRepository();
        }
        return $this;
    }

    /**
     * @return ApiController
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getRepository()
    {
        $this->repository = $this->getEm()->getRepository($this->entity);
        return $this;
    }

    /**
     * @return AbstractFilter
     * @throws NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function getFilter(): AbstractFilter
    {
        if (!$this->container->has($this->filter)):
            $this->setServiceManager($this->filter, $this->factoryFilter);
        endif;
        $this->filter = $this->serviceManager->get($this->filter);
        return $this->filter;
    }

    /**
     * @return AbstractController
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getForm()
    {
        if (!$this->container->has($this->form)):
            $this->setServiceManager($this->form, $this->factoryForm);
        endif;
        $this->form = $this->serviceManager->get($this->form);
        return $this->form;
    }

    /**
     * @return AbstractController
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getService()
    {
        if (!$this->container->has($this->service)):
            $this->setServiceManager($this->service, $this->factoryService);
        endif;
        $this->service = $this->serviceManager->get($this->service);
        return $this->service;
    }

    /**
     * @return EntityManager
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getEm(): EntityManager
    {
        if (is_null($this->em)):
            $this->em = $this->container->get("Doctrine\ORM\EntityManager");
        endif;
        return $this->em;
    }

    /**
     * @param string $table
     * @return ApiController
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function setTable( $table )
    {
        $this->table = $this->serviceManager->get($table);
        return $this;
    }

}
