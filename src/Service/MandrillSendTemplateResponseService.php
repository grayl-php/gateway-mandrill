<?php

namespace Grayl\Gateway\Mandrill\Service;

use Grayl\Gateway\Common\Service\ResponseServiceInterface;
use Grayl\Gateway\Mandrill\Entity\MandrillSendTemplateResponseData;

/**
 * Class MandrillSendTemplateResponseService
 * The service for working with Mandrill API gateway send template responses
 *
 * @package Grayl\Gateway\Mandrill
 */
class MandrillSendTemplateResponseService implements
    ResponseServiceInterface
{

    /**
     * Returns a true / false value based on the API response
     *
     * @param MandrillSendTemplateResponseData $response_data The response object to check
     *
     * @return bool
     */
    public function isSuccessful($response_data): bool
    {

        // For a successful response
        if ( ! $this->hasSendFailures($response_data)) {
            // Success
            return true;
        }

        // Failed
        return false;
    }


    /**
     * Returns a string of all recipient reference IDs from a MandrillSendTemplateResponseData
     * Each ID is separated by a colon ( : )
     *
     * @param MandrillSendTemplateResponseData $response_data The response object to pull reference IDs from
     *
     * @return string
     */
    public function getReferenceID($response_data): ?string
    {

        // Make sure the response is a populated array
        if (empty ($response_data->getAPIResponse())
            || ! is_array(
                $response_data->getAPIResponse()
            )
        ) {
            // Empty data
            return null;
        }

        // Create an array of recipient IDs found
        $ids = [];

        // Check each recipient in the response
        foreach (
            $response_data->getAPIResponse() as $recipient
        ) {
            // Check the ID
            if ( ! empty($this->getRecipientID($recipient))) {
                // Add it
                $ids[] = $this->getRecipientID($recipient);
            }
        }

        // If we found IDs to return
        if (count($ids) > 0) {
            // Return all IDs joined by a colon
            return join(
                ':',
                $ids
            );
        }

        // Nothing found
        return null;
    }


    /**
     * Returns the status message from a gateway API response
     *
     * @param MandrillSendTemplateResponseData $response_data The response object to get the message from
     *
     * @return string
     */
    public function getMessage($response_data): ?string
    {

        // Set the data
        $data = $response_data->getAPIResponse();

        // Make sure the response is a populated array with a message
        if ( ! empty ($data) && isset($data[0]['reject_reason'])) {
            // Return the message
            return $data[0]['reject_reason'];
        }

        // No message
        return null;
    }


    /**
     * Returns the raw data from a gateway API response
     *
     * @param MandrillSendTemplateResponseData $response_data The response object to get the data from
     *
     * @return array
     */
    public function getData($response_data): array
    {

        // Return the raw array response
        return $response_data->getAPIResponse();
    }


    /**
     * Checks to see if this response has failed sends to any recipient
     *
     * @param MandrillSendTemplateResponseData $response_data The response object to check for failures
     *
     * @return bool
     */
    private function hasSendFailures(
        MandrillSendTemplateResponseData $response_data
    ): bool {

        // Make sure the response is a populated array
        if (empty ($response_data->getAPIResponse())
            || ! is_array(
                $response_data->getAPIResponse()
            )
        ) {
            // Empty data, failed
            return true;
        }

        // Check each recipient in the response
        foreach (
            $response_data->getAPIResponse() as $recipient
        ) {
            // Check the individual status
            if ( ! $this->isRecipientSuccessful($recipient)) {
                // Individual recipient failed
                return true;
            }
        }

        // No failures
        return false;
    }


    /**
     * Checks the response status of an individual recipient
     *
     * @param array $recipient The individual API response object to check for status
     *
     * @return bool
     */
    private function isRecipientSuccessful(array $recipient): bool
    {

        // See if the response was successful
        if ( ! empty($recipient['status'])
            && ($recipient['status'] == 'sent'
                || $recipient['status'] == 'queued')
        ) {
            // Success
            return true;
        }

        // Failed
        return false;
    }


    /**
     * Gets the recipient ID for an individual recipient
     *
     * @param array $recipient The individual API response object to check for ID
     *
     * @return ?string
     */
    private function getRecipientID(array $recipient): ?string
    {

        // See if there in an ID in the recipient data
        if ( ! empty($recipient['_id'])) {
            // Success
            return $recipient['_id'];
        }

        // No ID
        return null;
    }

}