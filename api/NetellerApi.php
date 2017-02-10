<?php
namespace grandmasterx\neteller\api;

/**
 * Class NetellerAPI
 * @package grandmasterx\neteller\api
 */
class NetellerAPI
{

    /**
     * @var
     */
    public $baseUrl;

    /**
     * @var
     */
    public $clientId;

    /**
     * @var
     */
    public $clientSecret;

    /**
     * @return string
     */
    public function getIP() {
        return file_get_contents('http://whatismyip.akamai.com');
    }

    /**
     * @param $path
     * @param array $queryParams
     * @param $headers
     * @return array
     */
    public function get($path, $queryParams = [], $headers) {
        return $this->makeHttpRequest("get", $path, $queryParams, $headers);
    }

    /**
     * @param $path
     * @param array $queryParams
     * @param $headers
     * @param array $requestParams
     * @return array
     */
    public function post($path, $queryParams = [], $headers, $requestParams = []) {
        return $this->makeHttpRequest("post", $path, $queryParams, $headers, $requestParams);
    }

    /**
     * @param $path
     * @param array $queryParams
     * @param $headers
     * @param array $requestParams
     * @return array
     */
    public function put($path, $queryParams = [], $headers, $requestParams = []) {
        return $this->makeHttpRequest("put", $path, $queryParams, $headers, $requestParams);
    }

    /**
     * @param $path
     * @param array $queryParams
     * @param $headers
     * @param array $requestParams
     * @return array
     */
    public function delete($path, $queryParams = [], $headers, $requestParams = []) {
        return $this->makeHttpRequest("delete", $path, $queryParams, $headers, $requestParams);
    }

    /**
     * @param $url
     * @return bool|mixed
     */
    public function getUrl($url) {
        $token = $this->getToken_ClientCredentials();

        if ($token == false) {
            return false;
        }

        $path = str_replace(NETELLER_BASE_URL, "/", $url);

        $queryParams = [];

        $headers = [
            "Content-type"  => "application/json",
            "Authorization" => "Bearer " . $token
        ];

        $response = $this->makeHttpRequest("get", $path, $queryParams, $headers);

        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            return $responseBody;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error->code,
                'api_error_message' => $responseBody->error->message,
                'api_resource_used' => 'GET {url}'
            ];

            return false;
        } else {
            return false;
        }
    }

    /**
     * @param $baseUrl
     * @param $clientId
     * @param $clientSecret
     */
    public function setApiCredentials($baseUrl, $clientId, $clientSecret) {
        $this->baseUrl = $baseUrl;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return bool
     */
    public function getToken_ClientCredentials() {
        $queryParams = ["grant_type" => "client_credentials"];
        $headers = [
            "Content-type"  => "application/json",
            "Authorization" => "Basic " . base64_encode(NETELLER_CLIENT_ID . ":" . NETELLER_CLIENT_SECRET)
        ];
        $response = $this->post("v1/oauth2/token", $queryParams, $headers, []);
        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            return $responseBody->accessToken;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error,
                'api_error_message' => '',
                'api_resource_used' => 'v1/oauth2/token'
            ];
            return false;
        } else {
            return false;
        }
    }

    /**
     * @param $authCode
     * @param $redirectUri
     * @return bool
     */
    public function getToken_AuthCode($authCode, $redirectUri) {
        $queryParams = [
            "grant_type"   => "authorization_code",
            "code"         => $authCode,
            "redirect_uri" => $redirectUri
        ];
        $headers = [
            "Content-type"  => "application/json",
            "Authorization" => "Basic " . base64_encode(NETELLER_CLIENT_ID . ":" . NETELLER_CLIENT_SECRET)
        ];
        $response = $this->post("v1/oauth2/token", $queryParams, $headers, []);
        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            return $responseBody->accessToken;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error,
                'api_error_message' => '',
                'api_resource_used' => 'v1/oauth2/token/{authCode}'
            ];
            return false;
        } else {
            return false;
        }
    }

    /**
     * @param $refreshToken
     * @return bool
     */
    public function getToken_RefreshToken($refreshToken) {
        $queryParams = [
            "grant_type"    => "refresh_token",
            "refresh_token" => $refreshToken
        ];

        $headers = [
            "Content-type"  => "application/json",
            "Authorization" => "Basic " . base64_encode(NETELLER_CLIENT_ID . ":" . NETELLER_CLIENT_SECRET)
        ];

        $response = $this->post("v1/oauth2/token", $queryParams, $headers, []);
        $responseInfo = $response['info'];
        $responseBody = json_decode($response['body']);

        if ($responseInfo['http_code'] == 200) {
            return $responseBody->accessToken;
        } elseif ($responseInfo['http_code'] >= 400) {
            $this->executionErrors = [
                'http_status_code'  => $responseInfo['http_code'],
                'api_error_code'    => $responseBody->error,
                'api_error_message' => '',
                'api_resource_used' => 'v1/oauth2/token/{refreshToken}'
            ];
            return false;
        } else {
            return false;
        }
    }

    /**
     * @param $method
     * @param $path
     * @param array $queryParams
     * @param $headers
     * @param array $requestParams
     * @return array
     */
    protected function makeHttpRequest($method, $path, $queryParams = [], $headers, $requestParams = []) {
        $ch = curl_init();
        //set the timeout
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

        //do not attempt to validate SSL certificates
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        //return the data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //return the response headers
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        //method && request params:
        switch (strtolower($method)) {
            case 'delete':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if (count($requestParams) > 0) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($requestParams));
                }
                break;
            case 'put':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                if (count($requestParams) > 0) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($requestParams));
                }
                break;
            case 'post':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                if (count($requestParams) > 0) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestParams));
                }
                break;
            case 'get':
                break;
        }

        //headers
        $_headers = [];

        foreach ($headers as $key => $value) {
            $_headers[] = "$key: $value";
        }

        if (count($_headers) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $_headers);
        }

        //query params
        $url = $this->baseUrl . $path;
        if (count($queryParams) > 0) {
            $url .= '?';
            foreach ($queryParams as $key => $value) {
                $url .= $key . '=' . rawurlencode($value) . '&';
            }
            $url = rtrim($url, '&');
        }

        curl_setopt($ch, CURLOPT_URL, $url);

        //response data
        $data = curl_exec($ch);
        $info = curl_getinfo($ch);

        $response_headers = substr($data, 0, $info['header_size']);
        $response_body = substr($data, $info['header_size']);

        curl_close($ch);

        $response = [
            'headers' => $response_headers,
            'body'    => $response_body,
            'info'    => $info,
        ];

        return $response;
    }
}
