<?php

namespace MadisonSolutions\Adflex;

use JsonSerializable;
use Serializable;

/**
 * Represents the result of an attempt to capture payment via Adflex
 *
 * The shop platform should not create these objects directly. The intention is that these objects
 * are returned by library methods when an attempt to capture a payment is made.
 */
class CaptureResult implements JsonSerializable, Serializable
{
    /**
     * The status of the payment
     *
     * Will be one of 'unknown', 'authorised', 'declined', 'cancelled' or 'error'
     *
     * @var string
     */
    public $status;

    /**
     * Whether the payent has been taken - IE has any money changed hands
     *
     * Will be one of 'uncertain', 'yes', 'no'
     *
     * @var string
     */
    public $payment_taken;


    /**
     * The card scheme, if known
     *
     * @var string
     */
    public $scheme;

    /**
     * The card type, if known
     *
     * @var string
     */
    public $card_type;

    /**
     * The card last 4 digits, if known
     *
     * @var string
     */
    public $last_4_digits;

    /**
     * An error message associated with the capture attempt
     *
     * @var string
     */
    public $error_msg;

    /**
     * Create a new CaptureResult instance
     */
    public function __construct()
    {
        $this->status = 'unknown';
        $this->payment_taken = 'uncertain';
    }

    /**
     * Convert the CaptureResult into an array of data
     */
    public function toArray()
    {
        return [
            'status' => $this->status,
            'payment_taken' => $this->payment_taken,
            'scheme' => $this->scheme,
            'card_type' => $this->card_type,
            'last_4_digits' => $this->last_4_digits,
            'error_msg' => $this->error_msg,
        ];
    }

    /**
     * Get the data to be used in the JSON serialization of this object
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Serialize this object to a string
     */
    public function serialize()
    {
        return serialize($this->toArray());
    }

    /**
     * Unserialize this object from a string
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->status = $data['status'];
        $this->payment_taken = $data['payment_taken'];
        $this->scheme = $data['scheme'];
        $this->card_type = $data['card_type'];
        $this->last_4_digits = $data['last_4_digits'];
        $this->error_msg = $data['error_msg'];
    }
}
