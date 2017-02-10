<?php
namespace grandmasterx\neteller\api;

/**
 * Class LookupPlan
 * @package grandmasterx\neteller\api
 */
class LookupPlan extends NetellerAPI
{
    /**
     * @var
     */
    public $planId;

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

        $queryParams = [];

        $response = $this->get("v1/plans/" . $this->planId, $queryParams, $headers, []);

        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            return $responseBody;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error->code,
                'api_error_message' => $responseBody->error->message,
                'api_resource_used' => 'GET /v1/plans/{}'
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
