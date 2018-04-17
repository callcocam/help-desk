<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 19/03/2018
 * Time: 00:12
 */

namespace Core\Validate;


use DoctrineModule\Validator\NoObjectExists as DoctrineModuleNoObjectExists;
use Zend\Debug\Debug;

class NoObjectExists extends DoctrineModuleNoObjectExists
{
    protected $id=null;
    protected $messageTemplates = array(
        self::ERROR_OBJECT_FOUND    => "An object matching combination of fields was found",
    );
    /**
     * {@inheritDoc}
     */
    public function isValid($value, $context = null)
    {
         if($this->fields[0]==="id"){
            $this->id = $context['id'];
            unset($this->fields[0],$context['id']);
        }
        foreach($this->fields as $name => $val)
        {
             $valueArray[] = $context[$val];
        }
        $value = $this->cleanSearchValue($valueArray);
        $match = $this->objectRepository->findOneBy($value);
        if((int)$this->id){
            $matchId = $this->objectRepository->find($this->id);
            if (is_object($match) && $matchId->getId() !== $match->getId()) {
                $this->error(self::ERROR_OBJECT_FOUND, $value);
                return false;
            }
        }
        else{
            if (is_object($match)) {
                $this->error(self::ERROR_OBJECT_FOUND, $value);
                return false;
            }
        }

        return true;
    }
}