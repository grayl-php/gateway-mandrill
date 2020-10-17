<?php

namespace Grayl\Gateway\Mandrill\Entity;

use Grayl\Mixin\Common\Entity\KeyedDataBag;

/**
 * Class MandrillEmailAddress
 * The entity for an email address used in the Mandrill classes
 *
 * @package Grayl\Gateway\Mandrill
 */
class MandrillEmailAddress
{

    /**
     * A complete email address
     *
     * @var string
     */
    private string $email_address;

    /**
     * A name associated to the email address
     *
     * @var ?string
     */
    private ?string $display_name;

    /**
     * User specific merge tags to replace in the template ( key = value format )
     * These override anything set in the global merge tags for the template
     *
     * @var KeyedDataBag
     */
    private KeyedDataBag $merge_tags;


    /**
     * Class constructor
     *
     * @param string  $email_address A complete email address
     * @param ?string $display_name  A name associated to the email address
     * @param array   $merge_tags    The associative array of merge tags to set ( key => value )
     */
    public function __construct(
        string $email_address,
        ?string $display_name,
        array $merge_tags
    ) {

        // Create the merge tag bag
        $this->merge_tags = new KeyedDataBag();

        // Set the entity data
        $this->setEmailAddress($email_address);
        $this->setDisplayName($display_name);
        $this->setMergeTags($merge_tags);
    }


    /**
     * Gets the email address
     *
     * @return string
     */
    public function getEmailAddress(): string
    {

        // Return the email address
        return $this->email_address;
    }


    /**
     * Sets the email address
     *
     * @param string $email_address A complete email address
     */
    public function setEmailAddress(string $email_address): void
    {

        // Set the email address
        $this->email_address = $email_address;
    }


    /**
     * Gets the display name
     *
     * @return ?string
     */
    public function getDisplayName(): ?string
    {

        // Return the display name
        return $this->display_name;
    }


    /**
     * Sets the display name
     *
     * @param ?string $display_name A name associated to the email address
     */
    public function setDisplayName(?string $display_name): void
    {

        // Set the display name
        $this->display_name = $display_name;
    }


    /**
     * Sets a single merge tag
     *
     * @param string  $key   The key name for the merge tag
     * @param ?string $value The value of the merge tag
     */
    public function setMergeTag(
        string $key,
        ?string $value
    ): void {

        // Set the merge tag
        $this->merge_tags->setVariable(
            $key,
            $value
        );
    }


    /**
     * Retrieves the value of a stored merge tag
     *
     * @param string $key The key name for the merge tag
     *
     * @return mixed
     */
    public function getMergeTag(string $key)
    {

        // Return the value
        return $this->merge_tags->getVariable($key);
    }


    /**
     * Sets multiple merge tags using a passed array
     *
     * @param array $merge_tags The associative array of merge tags to set ( key => value )
     */
    public function setMergeTags(array $merge_tags): void
    {

        // Set the merge tags
        $this->merge_tags->setVariables($merge_tags);
    }


    /**
     * Retrieves the entire array of merge tags
     *
     * @return array
     */
    public function getMergeTags(): array
    {

        // Return all merge tags
        return $this->merge_tags->getVariables();
    }

}