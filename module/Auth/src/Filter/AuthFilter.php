<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 16/04/2018
 * Time: 18:26
 */

namespace Auth\Filter;


use Auth\Entity\User;
use Core\Filter\AbstractFilter;
use Interop\Container\ContainerInterface;
use Zend\InputFilter\InputFilter;

class AuthFilter extends AbstractFilter
{

    /**
     * FilterInterface constructor.
     * @param ContainerInterface $container
     */
    public function __construct( ContainerInterface $container )
    {
        $this->container = $container;
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter):
            $this->inputFilter = new InputFilter();
            $this->inputFilter->add([
                'name' => 'document',
                'required' => true,
                'filters' => $this->filters(),
                'validators' => [
                    $this->RecordExists(User::class),
                    $this->StringLength('E-Mail'),
                    $this->NotEmpty('E-Mail'),
                ]
            ]);

            $this->inputFilter->add([
                'name' => 'password',
                'required' => true,
                'filters' => $this->filters(),
                'validators' => [
                    $this->StringLength('Senha'),
                    $this->NotEmpty('Senha'),
                ]
            ]);
        endif;
        return parent::getInputFilter();
    }
}