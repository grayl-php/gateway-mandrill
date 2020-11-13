<?php

   namespace Grayl\Test\Gateway\Mandrill;

   use Grayl\File\FilePorter;
   use Grayl\Gateway\Mandrill\Controller\MandrillSendTemplateRequestController;
   use Grayl\Gateway\Mandrill\Controller\MandrillSendTemplateResponseController;
   use Grayl\Gateway\Mandrill\Entity\MandrillEmailAddress;
   use Grayl\Gateway\Mandrill\Entity\MandrillGatewayData;
   use Grayl\Gateway\Mandrill\MandrillPorter;
   use PHPUnit\Framework\TestCase;

   /**
    * Test class for the Mandrill package
    * Note: This test will only work when the sender is allowed in the Mandrill account
    *
    * @package Grayl\Gateway\Mandrill
    */
   class MandrillSendTemplateRequestControllerTest extends TestCase
   {

      /**
       * The name of the data file for this test
       *
       * @var string
       */
      protected static string $data_file = 'gateway-mandrill.data.php';

      /**
       * The test data
       *
       * @var \StdCLass
       */
      protected static \StdCLass $test_data;


      /**
       * Test setup for sandbox environment
       */
      public static function setUpBeforeClass (): void
      {

         // Change the Mandrill API to sandbox mode
         MandrillPorter::getInstance()
                       ->setEnvironment( 'sandbox' );

         // Get the data file
         $data_file = FilePorter::getInstance()
                                ->newFileController( dirname( $_SERVER[ 'DOCUMENT_ROOT' ] ) . '/tests/data/' . self::$data_file );

         // Create the config instance from the config file
         self::$test_data = $data_file->getIncludedFile();
      }


      /**
       * Tests the creation of a MandrillGatewayData object
       *
       * @return MandrillGatewayData
       * @throws \Exception
       */
      public function testCreateMandrillGatewayData (): MandrillGatewayData
      {

         // Create the object
         $gateway = MandrillPorter::getInstance()
                                  ->getSavedGatewayDataEntity( 'default' );

         // Check the type of object returned
         $this->assertInstanceOf( MandrillGatewayData::class,
                                  $gateway );

         // Return the object
         return $gateway;
      }


      /**
       * Tests the creation of a MandrillEmailAddress object
       *
       * @return MandrillEmailAddress
       */
      public function testCreateMandrillEmailAddress (): MandrillEmailAddress
      {

         // Create the object
         $email_address = MandrillPorter::getInstance()
                                        ->newMandrillEmailAddress( self::$test_data->sender_email_address,
                                                                   'Test Suite',
                                                                   [] );

         // Check the type of object returned
         $this->assertInstanceOf( MandrillEmailAddress::class,
                                  $email_address );

         // Return the object
         return $email_address;
      }


      /**
       * Tests the creation of a MandrillSendTemplateRequestController object
       *
       * @param MandrillEmailAddress $sender A fully populated MandrillEmailAddress instance to send to
       *
       * @return MandrillSendTemplateRequestController
       * @depends testCreateMandrillEmailAddress
       * @throws \Exception
       */
      public function testCreateMandrillSendTemplateRequestController ( MandrillEmailAddress $sender ): MandrillSendTemplateRequestController
      {

         // Create the object
         $request = MandrillPorter::getInstance()
                                  ->newMandrillSendTemplateRequestController( 'test',
                                                                              'handlebars',
                                                                              'Testing',
                                                                              $sender,
                                                                              [ MandrillPorter::getInstance()
                                                                                              ->newMandrillEmailAddress( self::$test_data->recipient_email_addresses[ 0 ],
                                                                                                                         'Tester',
                                                                                                                         [ 'test_user_var' => 'Test user tag dev' ] ),
                                                                                MandrillPorter::getInstance()
                                                                                              ->newMandrillEmailAddress( self::$test_data->recipient_email_addresses[ 1 ],
                                                                                                                         'Webmaster',
                                                                                                                         [ 'test_user_var' => 'Test user tag webmaster' ] ), ],
                                                                              [ 'test' ],
                                                                              [ 'test_content' => 'Global test content' ],
                                                                              [ "test_global_var"    => 'Global test merge tag',
                                                                                "global_indexed"     => [ 'First',
                                                                                                          'Second',
                                                                                                          'Third', ],
                                                                                "global_associative" => [ [ 'title' => 'first',
                                                                                                            'alias' => 1, ],
                                                                                                          [ 'title' => 'second',
                                                                                                            'alias' => 2, ],
                                                                                                          [ 'title' => 'third',
                                                                                                            'alias' => 3, ], ], ] );

         // Check the type of object returned
         $this->assertInstanceOf( MandrillSendTemplateRequestController::class,
                                  $request );

         // Return the object
         return $request;
      }


      /**
       * Tests the sending of a MandrillSendTemplateRequestData through a MandrillSendTemplateRequestController
       *
       * @param MandrillSendTemplateRequestController $request A configured MandrillSendTemplateRequestController entity to use as a gateway
       *
       * @depends testCreateMandrillSendTemplateRequestController
       * @return MandrillSendTemplateResponseController
       * @throws \Exception
       */
      public function testSendMandrillSendTemplateRequestController ( MandrillSendTemplateRequestController $request )
      {

         // Send the request using the gateway
         $response = $request->sendRequest();

         // Check the type of object returned
         $this->assertInstanceOf( MandrillSendTemplateResponseController::class,
                                  $response );

         // Return the response
         return $response;
      }


      /**
       * Checks a MandrillSendTemplateResponseController for data and errors
       *
       * @param MandrillSendTemplateResponseController $response A MandrillSendTemplateResponseController returned from the gateway
       *
       * @depends testSendMandrillSendTemplateRequestController
       */
      public function testMandrillSendTemplateResponseController ( MandrillSendTemplateResponseController $response ): void
      {

         // Test the data
         $this->assertTrue( $response->isSuccessful() );
         $this->assertNotNull( $response->getReferenceID() );

         // Test the raw data
         $this->assertIsArray( $response->getData() );
      }

   }
