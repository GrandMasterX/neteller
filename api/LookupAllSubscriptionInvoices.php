<?php
namespace grandmasterx\neteller\api;

/**
 * Class LookupAllSubscriptionInvoices
 * @package grandmasterx\neteller\api
 */
class LookupAllSubscriptionInvoices extends NetellerAPI
{

    /**
     * @var
     */
    public $subscriptionId;

    /**
     * @var
     */
    public $limit;

    /**
     * @var
     */
    public $offset;

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
     * @param $limit
     * @return $this
     */
    public function setLimit($limit) {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param $offset
     * @return $this
     */
    public function setOffset($offset) {
        $this->offset = $offset;
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

        $queryParams = [
            "limit"  => $this->limit,
            "offset" => $this->offset
        ];

        $response = $this->get("v1/subscriptions/" . $this->subscriptionId . "/invoices", $queryParams, $headers, []);

        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            return $responseBody;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error->code,
                'api_error_message' => $responseBody->error->message,
                'api_resource_used' => 'GET /v1/subscriptions/{subscriptionId}/invoices'
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
