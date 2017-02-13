<?php
namespace grandmasterx\neteller\api;

/**
 * Class CreatePlan
 * @package grandmasterx\neteller\api
 */
class CreatePlan extends NetellerApi
{

    /**
     * @var
     */
    public $planId;

    /**
     * @var
     */
    public $planName;

    /**
     * @var
     */
    public $interval;

    /**
     * @var
     */
    public $intervalType;

    /**
     * @var
     */
    public $intervalCount;

    /**
     * @var
     */
    public $amount;

    /**
     * @var
     */
    public $currency;

    /**
     * @var
     */
    public $executionErrors;

    /**
     * @param $planId
     * @return $this
     */
    public function setPlanId($planId) {
        $this->planId = $planId;
        return $this;
    }

    /**
     * @param $planName
     * @return $this
     */
    public function setPlanName($planName) {
        $this->planName = $planName;
        return $this;
    }

    /**
     * @param $interval
     * @return $this
     */
    public function setInterval($interval) {
        $this->interval = $interval;
        return $this;
    }

    /**
     * @param $intervalType
     * @return $this
     */
    public function setIntervalType($intervalType) {
        $this->intervalType = $intervalType;
        return $this;
    }

    /**
     * @param $intervalCount
     * @return $this
     */
    public function setIntervalCount($intervalCount) {
        $this->intervalCount = $intervalCount;
        return $this;
    }

    /**
     * @param $amount
     * @return $this
     */
    public function setAmount($amount) {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param $currency
     * @return $this
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
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

        $requestParams = [
            "planId"        => $this->planId,
            "planName"      => $this->planName,
            "interval"      => $this->interval,
            "intervalType"  => $this->intervalType,
            "intervalCount" => $this->intervalCount,
            "amount"        => $this->amount,
            "currency"      => $this->currency
        ];

        $queryParams = [];

        $response = $this->post("v1/plans", $queryParams, $headers, $requestParams);
        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            return $responseBody;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error->code,
                'api_error_message' => $responseBody->error->message,
                'api_resource_used' => 'POST v1/plans'
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
