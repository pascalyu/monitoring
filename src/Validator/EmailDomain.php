<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

/**
 * @Annotation
 */
class EmailDomain extends Constraint


{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'The value "{{ value }}" is not valid.';

    public $blocked=[]; 

    public function __construct($options = [])
    {
        parent::__construct($options);
        if (!is_array($options["blocked"])) {
            throw new ConstraintDefinitionException("the blocked chain must be an array of blocked domain");
        }
    }

    /**
     * Returns the name of the required options.
     *
     * Override this method if you want to define required options.
     *
     * @return array
     *
     * @see __construct()
     */
    public function getRequiredOptions()
    {
        return ["blocked"];
    }
}
