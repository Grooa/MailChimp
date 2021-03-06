<?php

namespace Plugin\Mailchimp;

class Event
{

    /**
     * Calls the api
     */
    public static function Mailchimp_registerSubscription($data)
    {
        if (!empty($data['errors'])) {
            return null;
        }

        $post = $data['post'];

        $member = [
            'email' => $post['email'],
            'fname' => $post['firstName'],
            'lname' => $post['lastName'],
            'interests' => ['626ca3f0eb', '6855f22992']
        ];

        try {
            Model::addMemberToList($member);
        } catch (\Exception $e) {
            ipLog()->error('[Mailchimp_subscribe Error]', [
                'error' => $e->getMessage(),
                'member' => $member
            ]);
            return null;
        }

        self::notifyWebmaster(
            "Mailchimp New Subscriber",
            "Hi!\r\nSomeone has subscribed to our newsletters:\r\n\r\n"
            . $post['firstName'] . "\r\n"
            . $post['lastName'] . "\r\n"
        );
    }

    public static function User_register($data)
    {
        $postData = $data['postData'];
        $allowNewsletters = !empty($postData['allowNewsletters']);
        $recipient = ipGetOption('Mailchimp.recipientEmail', 'webmaster@grooa.com');

        self::notifyWebmaster('New User',
            "Hi\r\nSomeone has registered for a user:\r\n\r\n"
            . $postData['firstName'] . "\r\n" . $postData['lastName'] . "\r\nNewsletter: "
            . ($allowNewsletters ? 'yes' : 'no')
        );

        if ($allowNewsletters) {
            $member = [
                'email' => $postData['email'],
                'fname' => $postData['firstName'],
                'lname' => $postData['lastName'],
                'interests' => ['626ca3f0eb', '6855f22992'] // InterestIds (get them from MailChimp API Playground)
            ];

            try {
                Model::addMemberToList($member);
            } catch (\Exception $e) {
                // Exceptions thrown aren't fatal. Logging it is enough.
                ipLog()->error(
                    "[User_register Subscription Error] \n" . $e->getMessage(),
                    $member
                );
            }
        }

    }

    private static function notifyWebmaster($subject, $content, $member = []) {
        $recipient = ipGetOption('Mailchimp.recipientEmail', 'webmaster@grooa.com');

        ipSendEmail(
            ipGetOptionLang('Config.websiteEmail'),
            ipGetOptionLang('Config.websiteTitle'),
            $recipient,
            $recipient,
            $subject,
            $content,
            true,
            false
        );
    }

}
