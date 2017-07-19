<?php

namespace Plugin\Mailchimp;

class Slot
{
    public static function Mailchimp_subscriptionForm($params)
    {
        $params['form'] = FormModel::createSubscriptionForm($params);

        return ipView('view/subscriptionForm.php', $params)->render();
    }
}