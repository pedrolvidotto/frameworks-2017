<?php

namespace Application\Model;

use Zend\InputFilter\InputFilter;

class Client
{
    public $password;
    public $email;
    public $id;

    /**
     * @return Zend\InputFilter\InputFilter
     */
    public function getInputFilter()
    {
        $inputFilter = new InputFilter();

        $inputFilter->add(array(
            'name'     => 'id',
            'required' => false,
            'filters'  => array(
                array('name' => 'Int'),
            ),
        ));


        $inputFilter->add(array(
            'name'     => 'email',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),

            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 3,
                        'max'      => 100,
                    ),
                ),
            ),
        ));

        $inputFilter->add(array(
            'name'     => 'password',
            'required' => true,

            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),

            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 3,
                        'max'      => 100,
                    ),
                ),
            ),
        ));

        return $inputFilter;
    }
}
