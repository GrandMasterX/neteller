<?php
namespace grandmasterx\neteller\api;

/**
 * Class CreateSubscription
 * @package grandmasterx\neteller\api
 */
class CreateSubscription extends NetellerApi
{

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
    public $redirectUri;

    /**
     * @var
     */
    public $planId;

    /**
     * @var
     */
    public $customerId;

    /**
     * @var
     */
    public $startDate;

    /**
     * @var
     */
    public $expandObjects;

    /**
     * @param $planId
     * @return $this
     */
    public function setPlanId($planId) {
        $this->planId = $planId;
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
     * @param $startDate
     * @return $this
     */
    public function setStartDate($startDate) {
        $this->startDate = $startDate;
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
     * @param $authCode
     * @return $this
     */
    public function setAuthCode($authCode) {
        $this->authCode = $authCode;
        return $this;
    }

    /**
     * @param $redirectUri
     * @return $this
     */
    public function setRedirectUri($redirectUri) {
        $this->redirectUri = $redirectUri;
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
        if (isset($this->authCode)) {
            $token = $this->getToken_AuthCode($this->authCode, $this->redirectUri);
        } elseif (isset($this->refreshToken)) {
            $token = $this->getToken_RefreshToken($this->refreshToken);
        } else {
            $this->executionErrors[] = ['POST /v1/oauth2/token' => "Either Auth code or Refresh Token must be provided"];
            return false;
        }

        if ($token == false) {
            return false;
        }

        $headers = [
            "Content-type"  => "application/json",
            "Authorization" => "Bearer " . $token
        ];

        $requestParams = [
            "planId"     => $this->planId,
            "customerId" => $this->customerId,
            "startDate"  => $this->startDate
        ];

        if (isset($this->expandObjects)) {
            $queryParams = ['expand' => $this->expandObjects];
        } else {
            $queryParams = [];
        }
        $response = $this->post("v1/subscriptions", $queryParams, $headers, $requestParams);
        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            return $responseBody;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error->code,
                'api_error_message' => $responseBody->error->message,
                'api_resource_used' => 'POST /v1/subscriptions'
            ];
            return false;
        } else {
            return false;
        }
    }
}
