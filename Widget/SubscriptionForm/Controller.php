<?php

namespace Plugin\Mailchimp\Widget\SubscriptionForm;

class Controller extends \Ip\WidgetController
{

    public function generateHtml($revisionId, $widgetId, $data, $skin)
    {
        if (empty($data['interest'])) {
            $data['interest'] = [];
        }

        if (empty($data['description'])) {
            $data['description'] = null;
        }

        return parent::generateHtml($revisionId, $widgetId, $data, $skin);
    }
}