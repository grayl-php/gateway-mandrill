<?php

   namespace Grayl\Gateway\Mandrill\Controller;

   use Grayl\Gateway\Common\Controller\RequestControllerAbstract;
   use Grayl\Gateway\Mandrill\Entity\MandrillSendTemplateRequestData;
   use Grayl\Gateway\Mandrill\Entity\MandrillSendTemplateResponseData;

   /**
    * Class MandrillSendTemplateRequestController
    * The controller for working with MandrillSendTemplateRequestData entities
    * @method MandrillSendTemplateRequestData getRequestData()
    * @method MandrillSendTemplateResponseController sendRequest()
    *
    * @package Grayl\Gateway\Mandrill
    */
   class MandrillSendTemplateRequestController extends RequestControllerAbstract
   {

      /**
       * Creates a new MandrillSendTemplateResponseController to handle data returned from the gateway
       *
       * @param MandrillSendTemplateResponseData $response_data The MandrillSendTemplateResponseData entity received from the gateway
       *
       * @return MandrillSendTemplateResponseController
       */
      public function newResponseController ( $response_data ): object
      {

         // Return a new MandrillSendTemplateResponseController entity
         return new MandrillSendTemplateResponseController( $response_data,
                                                            $this->response_service );
      }

   }