<?php

namespace Grayl\Gateway\Mandrill\Entity;

use Grayl\Gateway\Common\Entity\GatewayDataAbstract;
use Mandrill;

/**
 * Class MandrillGatewayData
 * The entity for the Mandrill API
 * @method void __construct(Mandrill $api, string $gateway_name, string $environment)
 * @method void setAPI(Mandrill $api)
 * @method Mandrill getAPI()
 *
 * @package Grayl\Gateway\Mandrill
 */
class MandrillGatewayData extends
    GatewayDataAbstract
{

    /**
     * Fully configured Mandrill entity
     *
     * @var Mandrill
     */
    protected $api;

}