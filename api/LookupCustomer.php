<?php
namespace grandmasterx\neteller\api;

/**
 * Class LookupCustomer
 * @package grandmasterx\neteller\api
 */
class LookupCustomer extends NetellerApi
{

    /**
     * @var
     */
    public $accountId;

    /**
     * @var
     */
    public $customerId;

    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    public $authCode;

    /**
     * @var
     */
    public $refreshToken;

    /**
     * @var
     */
    public $executionErrors;

    /**
     * @param $accountId
     * @return $this
     */
    public function setAccountId($accountId) {
        $this->accountId = $accountId;
        return $this;
    }

    /**
     * @param $customerId
     * @return $this
     */
    public function setCustomerId($customerId) {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * @param $authCode
     * @return $this
     */
    public function setAuthCode($authCode) {
        $this->authCode = $authCode;
        return $this;
    }

    /**
     * @param $refreshToken
     * @return $this
     */
    public function setRefreshToken($refreshToken) {
        $this->refreshToken = $refreshToken;
        return $this;
    }

    /**
     * @return bool|mixed
     */
    public function doRequest() {
        if (isset($this->authCode)) {
            $token = $this->getToken_AuthCode($this->authCode);
        }

        if (isset($this->refreshToken)) {
            $token = $this->getToken_RefreshToken($this->refreshToken);
        }

        if (!isset($this->authCode) AND !isset($this->refreshToken)) {
            $token = $this->getToken_ClientCredentials();
        }

        if ($token == false) {
            return false;
        }

        $headers = [
            "Content-type"  => "application/json",
            "Authorization" => "Bearer " . $token
        ];

        if (isset($this->customerId)) {
            $queryParams = [];
            $response = $this->get("v1/customers/" . $this->customerId, $queryParams, $headers, []);
        }

        if (isset($this->accountId)) {
            $queryParams = [
                "accountId" => $this->accountId
            ];
            $response = $this->get("v1/customers/", $queryParams, $headers, []);
        }

        if (isset($this->email)) {
            $queryParams = [
                "email" => $this->email
            ];
            $response = $this->get("v1/customers/", $queryParams, $headers, []);
        }

        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            return $responseBody;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error->code,
                'api_error_message' => $responseBody->error->message,
                'api_resource_used' => 'GET /v1/customers/{}'
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
