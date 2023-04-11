<?php

declare(strict_types=1);

namespace App\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Callback;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Regex;

class SubscribeUserInputFilter extends InputFilter
{
    public function __construct()
    {
        $email = new Input('email');
        $email->setRequired(true);
        $email->setAllowEmpty(true);
        $email->getValidatorChain()
            ->attach(new EmailAddress())
            ->attach(new Callback(
                [
                    'callback' => function($value, $context) {
                        if (empty($context['mobile']) && $value === '') {
                            /** @var Input $mobileInput */
                            $mobileInput = $this->getInputs()['email'];
                            $mobileInput->setAllowEmpty(false);
                            return false;
                        }
                        return true;
                    },
                    'messages' => [
                        'callbackValue' => 'To subscribe, you need to provide at least your email address or your mobile number',
                    ],
                ]
            ))
        ;
        $email->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());

        $mobile = new Input('mobile');
        $mobile->setRequired(true);
        $mobile->setAllowEmpty(true);
        $mobile->getValidatorChain()
            ->attach(new Regex('/^(\+[1-9]\d{1,14}|\+[1-9]{2} \d{3} \d{4} \d{4})$/'))
            ->attach(new Callback(
                [
                    'callback' => function($value, $context) {
                        if (empty($context['email']) && $value === '') {
                            /** @var Input $mobileInput */
                            $mobileInput = $this->getInputs()['mobile'];
                            $mobileInput->setAllowEmpty(false);
                            return false;
                        }
                        return true;
                    },
                    'messages' => [
                        'callbackValue' => 'To subscribe, you need to provide at least your email address or your mobile number',
                    ],
                ]
            ));
        $mobile->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());

        $address = new Input('address');
        $address->setRequired(true);
        $address->setAllowEmpty(false);
        $address->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());

        $this
            ->add($address)
            ->add($mobile)
            ->add($email)
            ;

    }
}