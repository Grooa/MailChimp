<?php

namespace Plugin\Mailchimp;

use \Ip\Form\Field;

class Filter
{

	public static function User_registrationForm($form)
	{
		$form->addField(
			new Field\Text(array(
				'name' => 'firstName',
				'label' => 'First name',
			))
		);

		$form->addField(
			new Field\Text(array(
				'name' => 'lastName',
				'label' => 'Last name',
			))
		);

		$form->addField(
			new Field\Checkbox(array(
				'name' => 'allowNewsletters',
				'label' => 'Send me occasional newsletters',
				'value' => true,
			))
		);

		return $form;
	}


}
