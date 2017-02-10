<?php
namespace grandmasterx\neteller\api;

/**
 * Class LookupSubscription
 * @package grandmasterx\neteller\api
 */
class LookupSubscription extends NetellerAPI
{

    /**
     * @var
     */
    public $subscriptionId;

    /**
     * @var
     */
    public $expandObjects;

    /**
     * @var
     */
    public $executionErrors;

    /**
     * @param $subscriptionId
     * @return $this
     */
    public function setSubscriptionId($subscriptionId) {
        $this->subscriptionId = $subscriptionId;
        return $this;
    }

    /**
     * @param $expandObjects
     * @return $this
     */
    public function setExpand($expandObjects) {
        $this->expandObjects = $expandObjects;
        return $this;
    }

    /**
     * @return bool|mixed
     */
    public function doRequest() {
        $token = $this->getToken_ClientCredentials();

        if ($token == false) {
            return false;
        }

        $headers = [
            "Content-type"  => "application/json",
            "Authorization" => "Bearer " . $token
        ];

        if (isset($this->expandObjects)) {
            $queryParams = ['expand' => $this->expandObjects];
        } else {
            echo "expand is not set!";
            $queryParams = [];
        }

        $response = $this->get("v1/subscriptions/" . $this->subscriptionId, $queryParams, $headers);

        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            return $responseBody;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error->code,
                'api_error_message' => $responseBody->error->message,
                'api_resource_used' => 'GET /v1/subscriptions/{}'
            ];
            return false;
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getExecutionErrors() {
        return $this->executionErrors;
    }
}
