<?php
namespace Plugin\Mailchimp;

/**
 * Generic MailChimp member
 */
class Member {

    private $email, $status, $firstName, $lastName;
    private $interests = [];

    function __construct($firstName, $lastName, $email, $status = "subscribed")
    {
        $this->email = $email;
        $this->status = $status;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function addInterest($interest) {

    }
}