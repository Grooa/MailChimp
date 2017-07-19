<?php

namespace Plugin\Mailchimp;

class PublicController
{
    public function subscribe() {
        ipRequest()->mustBePost();

        $post = ipRequest()->getPost();
        $res = ['status' => 'ok'];
        $form = FormModel::createSubscriptionForm([]);

        $errors = $form->validate($post);

        $errors = ipFilter('Mailchimp_validateSubscriptionForm', $errors, $post);

        if ($errors) {
            $res['status'] = 'error';
            $res['errors'] = $errors;

            if (empty($post['lastName'])) {
                $res['errors']['lastName'] = "Last name is required by Mailchimp";
            }

            if (empty($post['firstName'])) {
                $res['errors']['firstName'] = "First name is required by Mailchimp";
            }
        } else {
            $res['success'] = 'Thank you for subscribing';
        }

        ipEvent("Mailchimp_registerSubscription", ['post' => $post]);
        return new \Ip\Response\Json($res);
    }
}