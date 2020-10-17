<?php

namespace Grayl\Gateway\Mandrill\Entity;

use Grayl\Gateway\Common\Entity\RequestDataAbstract;
use Grayl\Mixin\Common\Entity\FlatDataBag;
use Grayl\Mixin\Common\Entity\KeyedDataBag;

/**
 * Class MandrillSendTemplateRequestData
 * The entity for a send template request to Mandrill
 *
 * @package Grayl\Gateway\Mandrill
 */
class MandrillSendTemplateRequestData extends
    RequestDataAbstract
{

    /**
     * The slug of the actual template inside Mandrill
     *
     * @var string
     */
    private string $slug;

    /**
     * The merge language to use in the template (mailchimp or handlebars)
     *
     * @var string
     */
    private string $merge_language;

    /**
     * A subject for the email
     *
     * @var string
     */
    private string $subject;

    /**
     * A configured MandrillEmailAddress entity with the senders information
     *
     * @var MandrillEmailAddress
     */
    private MandrillEmailAddress $sender;

    /**
     * An array of MandrillEmailAddress objects that will each receive this email
     *
     * @var FlatDataBag
     */
    private FlatDataBag $recipients;

    /**
     * A set of tags that apply to this email template
     *
     * @var FlatDataBag
     */
    private FlatDataBag $tags;

    /**
     * A set of content that will replace place markers in the email template ( key = value format )
     * Note that this is an older method used to reference editable fields
     * Merge tags are typically used instead of content
     *
     * @var KeyedDataBag
     */
    private KeyedDataBag $content;

    /**
     * Global merge tags to replace in the template ( key = value format )
     *
     * @var KeyedDataBag
     */
    private KeyedDataBag $merge_tags;


    /**
     * Class constructor
     *
     * @param string                 $action         The action performed in this request (send, etc.)
     * @param string                 $slug           The slug of the actual template inside Mandrill
     * @param string                 $merge_language The merge language to use in the template (mailchimp or handlebars)
     * @param string                 $subject        A subject for the email
     * @param MandrillEmailAddress   $sender         A configured MandrillEmailAddress entity with the senders information
     * @param MandrillEmailAddress[] $recipients     An array of MandrillEmailAddress objects that will each receive this email
     * @param array                  $tags           A set of tags that apply to this email template
     * @param array                  $contents       A set of content that will replace place markers in the email template ( key = value format )
     * @param array                  $merge_tags     Global merge tags to replace in the template ( key = value format )
     */
    public function __construct(
        string $action,
        string $slug,
        string $merge_language,
        string $subject,
        MandrillEmailAddress $sender,
        array $recipients,
        array $tags,
        array $contents,
        array $merge_tags
    ) {

        // Call the parent constructor
        parent::__construct($action);

        // Create the bags
        $this->recipients = new FlatDataBag();
        $this->tags       = new FlatDataBag();
        $this->content    = new KeyedDataBag();
        $this->merge_tags = new KeyedDataBag();

        // Set the entity data
        $this->setSlug($slug);
        $this->setMergeLanguage($merge_language);
        $this->setSubject($subject);
        $this->setSender($sender);
        $this->putRecipients($recipients);
        $this->addTags($tags);
        $this->setContents($contents);
        $this->setMergeTags($merge_tags);
    }


    /**
     * Gets the Mandrill template slug
     *
     * @return string
     */
    public function getSlug(): string
    {

        // Return the Mandrill template slug
        return $this->slug;
    }


    /**
     * Sets the Mandrill template slug
     *
     * @param string $slug The slug of the actual template inside Mandrill
     */
    public function setSlug(string $slug): void
    {

        // Set the template slug
        $this->slug = $slug;
    }


    /**
     * Gets the template merge language
     *
     * @return string
     */
    public function getMergeLanguage(): string
    {

        // Return the template merge language
        return $this->merge_language;
    }


    /**
     * Sets the template merge language
     *
     * @param string $merge_language The merge language to use in the template (mailchimp or handlebars)
     */
    public function setMergeLanguage(string $merge_language): void
    {

        // Set the template merge language
        $this->merge_language = $merge_language;
    }


    /**
     * Gets the email subject
     *
     * @return string
     */
    public function getSubject(): string
    {

        // Return the subject
        return $this->subject;
    }


    /**
     * Sets the email subject
     *
     * @param string $subject A subject for the email
     */
    public function setSubject(string $subject): void
    {

        // Set the subject
        $this->subject = $subject;
    }


    /**
     * Gets the sender
     *
     * @return MandrillEmailAddress
     */
    public function getSender(): MandrillEmailAddress
    {

        // Return the entity
        return $this->sender;
    }


    /**
     * Sets the sender
     *
     * @param MandrillEmailAddress $sender A configured MandrillEmailAddress entity with the senders information
     */
    public function setSender(MandrillEmailAddress $sender): void
    {

        // Set the entity
        $this->sender = $sender;
    }


    /**
     * Gets the array of recipients
     *
     * @return MandrillEmailAddress[]
     */
    public function getRecipients(): array
    {

        // Return the array of recipients
        return $this->recipients->getPieces();
    }


    /**
     * Puts a new MandrillEmailAddress entity into the bag of recipients
     *
     * @param MandrillEmailAddress $recipient The recipient MandrillEmailAddress entity to store
     */
    public function putRecipient(MandrillEmailAddress $recipient): void
    {

        // Store the recipient
        $this->recipients->putPiece($recipient);
    }


    /**
     * Stores multiple recipients using a passed array
     *
     * @param MandrillEmailAddress[] $recipients An array of MandrillEmailAddress objects that will each receive this email
     */
    public function putRecipients(array $recipients): void
    {

        // Store the recipients
        $this->recipients->putPieces($recipients);
    }


    /**
     * Gets the array of tags
     *
     * @return array
     */
    public function getTags(): array
    {

        // Return the array of tags
        return $this->tags->getPieces();
    }


    /**
     * Adds a new tag to the template
     *
     * @param string $tag The tag to add to the template
     */
    public function addTag(string $tag): void
    {

        // Add the tag
        $this->tags->putPiece($tag);
    }


    /**
     * Adds multiple tags to the template
     *
     * @param string[] $tags The tags to add to the template
     */
    public function addTags(array $tags): void
    {

        // Add the tags
        $this->tags->putPieces($tags);
    }


    /**
     * Gets the array of content
     *
     * @return array
     */
    public function getContent(): array
    {

        // Return the array of content
        return $this->content->getVariables();
    }


    /**
     * Sets a single piece of content
     *
     * @param string $key   The key of the content
     * @param mixed  $value The value of the content
     */
    public function setContent(
        string $key,
        ?string $value
    ): void {

        // Set the content
        $this->content->setVariable(
            $key,
            $value
        );
    }


    /**
     * Sets multiple pieces of content
     *
     * @param array $contents An associative array of content to set ( key => value )
     */
    public function setContents(array $contents): void
    {

        // Set the contents
        $this->content->setVariables($contents);
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
     * Retrieves the entire array of merge tags
     *
     * @return array
     */
    public function getMergeTags(): array
    {

        // Return all merge tags
        return $this->merge_tags->getVariables();
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

}