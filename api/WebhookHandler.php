<?php
namespace grandmasterx\neteller\api;

/**
 * Class WebhookHandler
 * @package grandmasterx\neteller\api
 */
class WebhookHandler extends NetellerApi
{

    /**
     *
     */
    public function handleRequest() {
        if (isset($_POST)) {
            $webhookData = file_get_contents("php://input");
            $webhookData = json_decode($webhookData);

            if (function_exists($webhookData->eventType)) {
                call_user_func($webhookData->eventType, $webhookData);
            }

            header('X-PHP-Response-Code: 200', true, 200);
        }

    }
}
