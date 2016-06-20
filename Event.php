<?php

namespace Plugin\Mailchimp;

class Event
{

	public static function User_register($data)
	{
		$postData = $data['postData'];
		$allowNewsletters = !empty($postData['allowNewsletters']);
		$recipient = ipGetOption('Mailchimp.recipientEmail', 'truls@grooa.com');

		ipSendEmail(
			ipGetOptionLang('Config.websiteEmail'),
			ipGetOptionLang('Config.websiteTitle'),
			$recipient,
			$recipient,
			'New User',
			"Hi!\r\nSomeone has registered for a user:\r\n"
				. $postData['firstName'] . "\r\n"
				. $postData['lastName'] . "\r\n"
				. $allowNewsletters ? 'yes' : 'no',
			true,
			false
		);

	}


}
