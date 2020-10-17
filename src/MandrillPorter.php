<?php

namespace Grayl\Gateway\Mandrill;

use Grayl\Gateway\Common\GatewayPorterAbstract;
use Grayl\Gateway\Mandrill\Controller\MandrillSendTemplateRequestController;
use Grayl\Gateway\Mandrill\Entity\MandrillEmailAddress;
use Grayl\Gateway\Mandrill\Entity\MandrillGatewayData;
use Grayl\Gateway\Mandrill\Entity\MandrillSendTemplateRequestData;
use Grayl\Gateway\Mandrill\Service\MandrillGatewayService;
use Grayl\Gateway\Mandrill\Service\MandrillSendTemplateRequestService;
use Grayl\Gateway\Mandrill\Service\MandrillSendTemplateResponseService;
use Grayl\Mixin\Common\Traits\StaticTrait;
use Mandrill;

/**
 * Front-end for the Mandrill package
 * @method MandrillGatewayData getSavedGatewayDataEntity (string $endpoint_id)
 *
 * @package Grayl\Gateway\Mandrill
 */
class MandrillPorter extends
    GatewayPorterAbstract
{

    // Use the static instance trait
    use StaticTrait;

    /**
     * The name of the config file for the Mandrill package
     *
     * @var string
     */
    protected string $config_file = 'gateway.mandrill.php';


    /**
     * Creates a new Mandrill object for use in a MandrillGatewayData entity
     *
     * @param array $credentials An array containing all of the credentials needed to create the gateway API
     *
     * @return Mandrill
     * @throws \Exception
     */
    public function newGatewayAPI(array $credentials): object
    {

        // Return the new API entity
        return new Mandrill($credentials['token']);
    }


    /**
     * Creates a new MandrillGatewayData entity
     *
     * @param string $endpoint_id The API endpoint ID to use (typically "default" is there is only one API gateway)
     *
     * @return MandrillGatewayData
     * @throws \Exception
     */
    public function newGatewayDataEntity(string $endpoint_id): object
    {

        // Grab the gateway service
        $service = new MandrillGatewayService();

        // Get an API
        $api = $this->newGatewayAPI(
            $service->getAPICredentials(
                $this->config,
                $this->environment,
                $endpoint_id
            )
        );

        // Configure the API as needed using the service
        $service->configureAPI(
            $api,
            $this->environment
        );

        // Return the gateway
        return new MandrillGatewayData(
            $api,
            $this->config->getConfig('name'),
            $this->environment
        );
    }


    /**
     * Creates a new MandrillSendTemplateRequestController entity
     *
     * @param string                 $slug           The slug of the actual template inside Mandrill
     * @param string                 $merge_language The merge language to use in the template (mailchimp or handlebars)
     * @param string                 $subject        A subject for the email
     * @param MandrillEmailAddress   $sender         A configured MandrillEmailAddress entity with the senders information
     * @param MandrillEmailAddress[] $recipients     An array of MandrillEmailAddress objects that will each receive this email
     * @param array                  $tags           A set of tags that apply to this email template
     * @param array                  $contents       A set of content that will replace place markers in the email template ( key = value format )
     * @param array                  $merge_tags     Global merge tags to replace in the template ( key = value format )
     *
     * @return MandrillSendTemplateRequestController
     * @throws \Exception
     */
    public function newMandrillSendTemplateRequestController(
        string $slug,
        string $merge_language,
        string $subject,
        MandrillEmailAddress $sender,
        array $recipients,
        array $tags,
        array $contents,
        array $merge_tags
    ): MandrillSendTemplateRequestController {

        // Create the MandrillSendTemplateRequestData entity
        $request_data = new MandrillSendTemplateRequestData(
            'sendTemplate',
            $slug,
            $merge_language,
            $subject,
            $sender,
            $recipients,
            $tags,
            $contents,
            $merge_tags
        );

        // Return a new MandrillSendTemplateRequestController entity
        return new MandrillSendTemplateRequestController(
            $this->getSavedGatewayDataEntity('default'),
            $request_data,
            new MandrillSendTemplateRequestService(),
            new MandrillSendTemplateResponseService()
        );
    }


    /**
     * Creates a new MandrillEmailAddress entity
     *
     * @param string  $email_address A complete email address
     * @param ?string $display_name  A name associated to the email address
     * @param array   $merge_tags    An array of user specific merge tags to set
     *
     * @return MandrillEmailAddress
     */
    public function newMandrillEmailAddress(
        string $email_address,
        ?string $display_name,
        array $merge_tags
    ): MandrillEmailAddress {

        // Return a new entity
        return new MandrillEmailAddress(
            $email_address,
            $display_name,
            $merge_tags
        );
    }

}