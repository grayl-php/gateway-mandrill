<?php

namespace Grayl\Gateway\Mandrill\Controller;

use Grayl\Gateway\Common\Controller\ResponseControllerAbstract;
use Grayl\Gateway\Common\Entity\ResponseDataAbstract;
use Grayl\Gateway\Common\Service\ResponseServiceInterface;
use Grayl\Gateway\Mandrill\Entity\MandrillSendTemplateResponseData;
use Grayl\Gateway\Mandrill\Service\MandrillSendTemplateResponseService;

/**
 * Class MandrillSendTemplateResponseController
 * The controller for working with MandrillSendTemplateResponseData entities
 *
 * @package Grayl\Gateway\Mandrill
 */
class MandrillSendTemplateResponseController extends
    ResponseControllerAbstract
{

    /**
     * The MandrillSendTemplateResponseData object that holds the gateway API response
     *
     * @var MandrillSendTemplateResponseData
     */
    protected ResponseDataAbstract $response_data;

    /**
     * The MandrillSendTemplateResponseService entity to use
     *
     * @var MandrillSendTemplateResponseService
     */
    protected ResponseServiceInterface $response_service;

}