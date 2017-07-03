<?php
namespace Plugin\Mailchimp;

use Ip\Exception;

/**
 * Simple Model which communicates with MailChimp API.
 */
class Model {

    private static $client, $secret;
    private static $baseUrl = "https://us12.api.mailchimp.com/3.0"; // us12 is our datacenter location

    /**
     * Will add a new member to the specified subscription-list (Plugin config or explicity as argument).
     *
     * $member requires the fields `fname`, `lname` and `email`. Other optional fields are,
     * `status` (default _subscribed_) and `interests`.
     * `interest` is a list of Group-item Ids (can be fetched through Mailchimp's API Sandbox)
     *
     * @param $member array : Object with keys fname, lname, email, status and interests
     * @param null $listId string : Accepts a listId for which list to append the member
     * @return  : GuzzleHttp\Client\Request
     * @throws Exception
     */
    public static function addMemberToList($member, $listId = null) {
        $listId = !empty($listId) ? $listId : ipGetOption('Mailchimp.listId');

        if (empty($listId)) {
            throw new Exception("Missing listId");
        }

        $body = [
            "email_address" => $member['email'],
            "status" => empty($member['status']) ? "subscribed" : $member['status']
        ];

        if (!empty($member['fname']) || !empty($member['lname'])) {
            $body['merge_fields'] = [];

            if (!empty($member['fname'])) {
                $body['merge_fields']['FNAME'] = $member['fname'];
            }

            if (!empty($member['lname'])) {
                $body['merge_fields']['LNAME'] = $member['lname'];
            }
        }

        // Interests Ids can be extracted from mailchimp api playground
        if (!empty($member['interests'])) {
            $body['interests'] = [];

            // Map array to object
            foreach ($member['interests'] as $i) {
                $body['interests'][$i] = true;
            }
        }

        try {
            $res = Model::$client->request('POST', Model::$baseUrl . "/lists/$listId/members/", [
                "auth" => ["anystring", Model::$secret],
                "headers" => ['Content-Type' => 'application/json'],
                "body" => json_encode($body)
            ]);

        } catch(\GuzzleHttp\Exception\ClientException $e) {
            throw new Exception($e->getResponse()->getBody());
        }

        return $res;
    }

    public static function init() {
        Model::$secret = ipGetOption('Mailchimp.secret');
        Model::$client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json']]);
    }
}
Model::init();