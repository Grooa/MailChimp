<?php

namespace Plugin\Mailchimp;

class Event
{

	public static function User_register($data)
	{
		$postData = $data['postData'];
		$allowNewsletters = !empty($postData['allowNewsletters']);
		$recipient = ipGetOption('Mailchimp.recipientEmail', 'webmaster@grooa.com');

		ipSendEmail(
			ipGetOptionLang('Config.websiteEmail'),
			ipGetOptionLang('Config.websiteTitle'),
			$recipient,
			$recipient,
			'New User',
			"Hi!\r\nSomeone has registered for a user:\r\n"
				. $postData['firstName'] . "\r\n"
				. $postData['lastName'] . "\r\n"
				. ($allowNewsletters ? 'yes' : 'no'),
			true,
			false
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
            } catch(\Exception $e) {
                // Exceptions thrown aren't fatal. Logging it is enough.
                ipLog()->error(
                    "[User_register Subscription Error] \n" . $e->getMessage(),
                    $member
                );
            }
        }

	}


}
