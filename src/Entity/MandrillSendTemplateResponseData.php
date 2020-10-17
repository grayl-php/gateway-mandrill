<?php

namespace Grayl\Gateway\Mandrill\Entity;

use Grayl\Gateway\Common\Entity\ResponseDataAbstract;

/**
 * Class MandrillSendTemplateResponseData
 * The class for working with a send template response from the Mandrill gateway
 * @method void __construct(array $api_response, string $gateway_name, string $action)
 * @method void setAPIResponse(array $api_response)
 * @method array getAPIResponse()
 *
 * @package Grayl\Gateway\Mandrill
 */
class MandrillSendTemplateResponseData extends
    ResponseDataAbstract
{

    /**
     * The raw API response entity from the gateway
     *
     * @var array
     */
    protected $api_response;

}