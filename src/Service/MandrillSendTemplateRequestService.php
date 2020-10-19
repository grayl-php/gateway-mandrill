<?php

   namespace Grayl\Gateway\Mandrill\Service;

   use Grayl\Gateway\Common\Service\RequestServiceInterface;
   use Grayl\Gateway\Mandrill\Entity\MandrillGatewayData;
   use Grayl\Gateway\Mandrill\Entity\MandrillSendTemplateRequestData;
   use Grayl\Gateway\Mandrill\Entity\MandrillSendTemplateResponseData;

   /**
    * Class MandrillSendTemplateRequestService
    * The service for working with Mandrill API send template requests
    *
    * @package Grayl\Gateway\Mandrill
    */
   class MandrillSendTemplateRequestService implements RequestServiceInterface
   {

      /**
       * Sends a MandrillSendTemplateRequestData object to the Mandrill gateway
       *
       * @param MandrillGatewayData             $gateway_data A configured MandrillGatewayData entity to send the request through
       * @param MandrillSendTemplateRequestData $request_data A MandrillSendTemplateRequestData entity to send
       *
       * @return MandrillSendTemplateResponseData
       * @noinspection PhpParamsInspection
       */
      public function sendRequestDataEntity ( $gateway_data,
                                              $request_data ): object
      {

         // Get the content
         $content = $this->translateContent( $request_data->getContent() );

         // Get the parameters
         $parameters = $this->translateMandrillSendTemplateRequestData( $request_data );

         // Build the request
         $api_request = $gateway_data->getAPI();

         // Send the request
         $response = $api_request->messages->sendTemplate( $request_data->getSlug(),
                                                           $content,
                                                           $parameters );

         // Return a new response entity with the action specified
         return $this->newResponseDataEntity( $response,
                                              $gateway_data->getGatewayName(),
                                              'sendTemplate',
                                              [] );
      }


      /**
       * Creates a new MandrillSendTemplateResponseData object to handle data returned from the gateway
       *
       * @param array    $api_response The response array received directly from a gateway
       * @param string   $gateway_name The name of the gateway
       * @param string   $action       The action performed in this response (send, sendTemplate, etc.)
       * @param string[] $metadata     Extra data associated with this response
       *
       * @return MandrillSendTemplateResponseData
       */
      public function newResponseDataEntity ( $api_response,
                                              string $gateway_name,
                                              string $action,
                                              array $metadata ): object
      {

         // Return a new MandrillSendTemplateResponseData entity
         return new MandrillSendTemplateResponseData( $api_response,
                                                      $gateway_name,
                                                      $action );
      }


      /**
       * Translates a MandrillSendTemplateRequestData object into the proper field format required by the gateway
       *
       * @param MandrillSendTemplateRequestData $request_data A MandrillSendTemplateRequestData entity to translate from
       *
       * @return array
       */
      private function translateMandrillSendTemplateRequestData ( MandrillSendTemplateRequestData $request_data ): array
      {

         // Create the return array
         $parameters = [];

         // Build the fields
         $parameters[ 'merge_language' ]    = $request_data->getMergeLanguage();
         $parameters[ 'subject' ]           = $request_data->getSubject();
         $parameters[ 'from_email' ]        = $request_data->getSender()
                                                           ->getEmailAddress();
         $parameters[ 'from_name ' ]        = $request_data->getSender()
                                                           ->getDisplayName();
         $parameters[ 'to' ]                = $this->translateRecipients( $request_data );
         $parameters[ 'global_merge_vars' ] = $this->translateMergeTags( $request_data->getMergeTags() );
         $parameters[ 'tags' ]              = $request_data->getTags();
         $parameters[ 'merge_vars' ]        = $this->translateRecipientMergeTags( $request_data );
         $parameters[ 'track_opens' ]       = true;
         $parameters[ 'track_clicks ' ]     = true;
         $parameters[ 'auto_text' ]         = true;

         // Return the array of parameters
         return $parameters;
      }


      /**
       * Translates an array of MandrillEmailAddress recipients into the API recipient format
       *
       * @param MandrillSendTemplateRequestData $request_data A MandrillSendTemplateRequestData entity to translate from
       *
       * @return array
       */
      private function translateRecipients ( MandrillSendTemplateRequestData $request_data ): array
      {

         // Create the return array
         $recipients = [];

         // Loop through the array of recipients
         foreach ( $request_data->getRecipients() as $recipient ) {
            // Format this recipient
            $recipients[] = [ 'email' => $recipient->getEmailAddress(),
                              'name'  => $recipient->getDisplayName(), ];
         }

         // Return the formatted array
         return $recipients;
      }


      /**
       * Translates an array of MandrillEmailAddress recipient's variables into the API merge var format
       *
       * @param MandrillSendTemplateRequestData $request_data A MandrillSendTemplateRequestData entity to translate from
       *
       * @return array
       */
      private function translateRecipientMergeTags ( MandrillSendTemplateRequestData $request_data ): array
      {

         // Create the return array
         $variables = [];

         // Loop through the array of recipients
         foreach ( $request_data->getRecipients() as $recipient ) {
            // Format this recipient
            $variables[] = [ 'rcpt' => $recipient->getEmailAddress(),
                             'vars' => $this->translateMergeTags( $recipient->getMergeTags() ), ];
         }

         // Return the formatted array
         return $variables;
      }


      /**
       * Translates an associative array of merge tags into the API general data format
       *
       * @param array $merge_tags An associative array of merge tags to translate (key => value format)
       *
       * @return array
       */
      private function translateMergeTags ( array $merge_tags ): array
      {

         // Create the return array
         $data = [];

         // Loop through the array of merge tags
         foreach ( $merge_tags as $key => $value ) {
            // Format this data
            $data[] = [ 'name'    => $key,
                        'content' => $value, ];
         }

         // Return the formatted array
         return $data;
      }


      /**
       * Translates an associative array of content into the API general data format
       *
       * @param array $content An associative array of content to translate (key => value format)
       *
       * @return array
       */
      private function translateContent ( array $content ): array
      {

         // Create the return array
         $data = [];

         // Loop through the array of content
         foreach ( $content as $key => $value ) {
            // Format this data
            $data[] = [ 'name'    => $key,
                        'content' => $value, ];
         }

         // Return the formatted array
         return $data;
      }

   }