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
        $fullName = new Input('fullName');
        $fullName->setRequired(true);
        $fullName->setAllowEmpty(false);
        $fullName->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());

        $address = new Input('address');
        $address->setRequired(true);
        $address->setAllowEmpty(false);
        $address->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());

        $email = new Input('email');
        $email->setRequired(true);
        $email->getValidatorChain()
            ->attach(new Callback(
                [
                    'callback' => function ($value, $context) {
                        if (empty($value) && empty($context['mobile'])) {
                            return false;
                        }
                        return true;
                    },
                    // phpcs:disable Generic.Files.LineLength
                    'messages' => [
                        Callback::INVALID_VALUE => 'To subscribe, you need to provide at least your email address or your mobile number',
                    ],
                    // phpcs:enable
                ]
            ))
            ->attach(new EmailAddress());
        $email->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());

        $mobile = new Input('mobile');
        $mobile->setRequired(true);

        $mobile->getValidatorChain()
            ->attach(
                new Callback(
                    [
                        'callback' => function ($value, $context) {
                            if (empty($value) && empty($context['email'])) {
                                return false;
                            }
                            return true;
                        },
                        'messages' => [
                            Callback::INVALID_VALUE => 'Either email or mobile is required',
                        ],
                    ]
                )
            )
            ->attach(new Regex('/^(\+[1-9]\d{1,14}|\+[1-9]{2} \d{3} \d{4} \d{4})$/'));
        $mobile->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());

        $this
            ->add($fullName)
            ->add($address)
            ->add($mobile)
            ->add($email);
    }
}
