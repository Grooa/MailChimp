<?php

namespace Plugin\Mailchimp;

class FormModel
{
    public static function createSubscriptionForm($data)
    {
        $form = new \Ip\Form();
        $form->addClass('horizontal mailchimp-subscription');
        $form->setAction(ipConfig()->baseUrl());
        $form->setMethod("post");

        $form->addField(new \Ip\Form\Field\Hidden([
            'name' => 'pa',
            'value' => 'Mailchimp.subscribe'
        ]));

        $form->addField(new \Ip\Form\Field\Email([
            'label' => 'Email',
            'name' => 'email',
            'title' => 'Email address',
            'validators' => ['Required']
        ]));

        $form->addField(new \Ip\Form\Field\Text([
            'label' => 'First name',
            'name' => 'firstName',
            'validators' => ['Required']
        ]));

        $form->addField(new \Ip\Form\Field\Text([
            'label' => 'Last name',
            'name' => 'lastName',
            'validators' => ['Required']
        ]));

        $form->addField(new \Ip\Form\Field\Submit([
            'layout' => \Ip\Form\Field::LAYOUT_NO_LABEL,
            'title' => 'Subscribe',
            'value' => 'Subscribe'
        ]));


        return $form;
    }
}