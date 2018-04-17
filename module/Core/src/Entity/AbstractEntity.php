<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Core\Entity;


use Zend\Hydrator\ClassMethods;
abstract class AbstractEntity
{


    /**
     * AbstractEntity constructor.
     * @param array $optinos
     */
    public function __construct( $optinos = array() )
    {

        $hydrate = new ClassMethods();
        $hydrate->hydrate($optinos, $this);


    }

    /**
     * @return array
     */
    public function toArray()
    {
        $hydrate = new ClassMethods();
        if (isset($this->parent))
            $parent = $this->parent->getId();
        else
            $parent = false;
        return $hydrate->extract($this);
    }



}