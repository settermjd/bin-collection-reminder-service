<?php

declare(strict_types=1);

namespace App\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\EmailAddress;

class UnsubscribeUserInputFilter extends InputFilter
{
    public function __construct()
    {
        $email = new Input('email');
        $email->setRequired(true);
        $email->getValidatorChain()
            ->attach(new EmailAddress());
        $email->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());
        $this->add($email);
    }
}
