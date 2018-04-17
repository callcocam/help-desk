<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 18/03/2018
 * Time: 16:35
 */

namespace Core\Filter;


use Core\Validate\NoObjectExists;
use DoctrineModule\Validator\ObjectExists;
use Interop\Container\ContainerInterface;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Validator\EmailAddress;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

abstract class AbstractFilter implements FilterInterface
{


    protected $inputFilter;
    /**
     * @var ContainerInterface
     */
    protected $container;




    public function getInputFilter(){
        ########################### status ####################
        $this->inputFilter->add([
            'name'=>'status',
            'required'=>false,
            'filters'=>$this->filters(),
            'validators'=>[
                $this->StringLength('Status')
            ]
        ]);
        ########################### id ####################
        $this->inputFilter->add([
            'name'=>'id',
            'required'=>false,
            'filters'=>$this->filters(),
            'validators'=>[
                $this->StringLength('Id')
            ]
        ]);
        ########################### id ####################
        $this->inputFilter->add([
            'name'=>'empresa',
            'required'=>false,
            'filters'=>$this->filters(),
            'validators'=>[
                $this->StringLength('Empresa'),
            ]
        ]);
        return $this->inputFilter;
    }

    protected function filters(){

        return [

            [
                'name'=>StringTrim::class,
            ],
            [
                'name'=>StripTags::class
            ]

        ];
    }

    public function StringLength($name, $max=255,$min=1){
        return[
            'name' => StringLength::class,
            'options' => [
                'max' => $max,
                'min' => $min,
                'messages' => [
                    StringLength::TOO_SHORT => "Campo [{$name}] Muito Curto",
                    StringLength::TOO_LONG => "Campo [{$name}] Muito Longo",
                ],
            ],
        ];
    }

    protected function NotEmpty($name){
        return [
            'name' => NotEmpty::class,
            'options' => [
                'messages' => [NotEmpty::IS_EMPTY => "Campo [{$name}] Obrigatorio"],
            ],
        ];
    }
    protected function EmailValitator($name){
        return [
            'name' => EmailAddress::class,
            'options' => [
                'messages' => [
                    EmailAddress::INVALID => "Campo [{$name}] E invalido",
                    EmailAddress::INVALID_FORMAT => "Campo [{$name}] Esta num formato invalido",
                    EmailAddress::INVALID_HOSTNAME => "Campo [{$name}] o host name e invalido",
                ],
            ],
        ];
    }

    public function getInputFilterSpecification($Entity,$field,$campo="Email")
    {
        $entityManager = $this->container->get('doctrine.entitymanager.orm_default');
        return [
            'name' => NoObjectExists::class,
            'options' => [
                'object_repository' => $entityManager->getRepository($Entity),
                'fields' => $field,
                'messages' => [
                    'objectFound' =>  "{$campo} Ja Existe!",
                ]
            ],
        ];
    }


    protected function NoRecordExists($Entity,$field="email",$campo="Email"){

        $entityManager = $this->container->get('doctrine.entitymanager.orm_default');
        return [
            'name' => NoObjectExists::class,
            'options' => [
                'object_repository' => $entityManager->getRepository($Entity),
                'fields' => $field,
                'messages' => [
                    'objectFound' =>  "{$campo} Ja Existe!",
                ]
            ],
        ];

    }

    protected function RecordExists($Entity="users",$field="email",$campo="Email"){

        $entityManager = $this->container->get('doctrine.entitymanager.orm_default');
        return [
            'name' => ObjectExists::class,
            'options' => [
                'object_repository' => $entityManager->getRepository($Entity),
                'fields' => $field,
                'messages' => [
                    ObjectExists::ERROR_NO_OBJECT_FOUND =>  "{$campo} Não Existe!",
                ]
            ],
        ];
    }



}