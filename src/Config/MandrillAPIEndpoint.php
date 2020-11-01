<?php

   namespace Grayl\Gateway\Mandrill\Config;

   use Grayl\Gateway\Common\Config\GatewayAPIEndpointAbstract;

   /**
    * Class MandrillAPIEndpoint
    * The class of a single Mandrill API endpoint
    *
    * @package Grayl\Gateway\Mandrill
    */
   class MandrillAPIEndpoint extends GatewayAPIEndpointAbstract
   {

      /**
       * The Mandrill token needed to communicate
       *
       * @var string
       */
      protected string $token;


      /**
       * Class constructor
       *
       * @param string $api_endpoint_id The ID of this API endpoint (default, provision, etc.)
       * @param string $token           The Mandrill token needed to communicate
       */
      public function __construct ( string $api_endpoint_id,
                                    string $token )
      {

         // Call the parent constructor
         parent::__construct( $api_endpoint_id );

         // Set the class data
         $this->setToken( $token );
      }


      /**
       * Gets the Mandrill token
       *
       * @return string
       */
      public function getToken (): string
      {

         // Return it
         return $this->token;
      }


      /**
       * Sets the Mandrill token
       *
       * @param string $token The Mandrill token needed to communicate
       */
      public function setToken ( string $token ): void
      {

         // Set the Mandrill token
         $this->token = $token;
      }

   }