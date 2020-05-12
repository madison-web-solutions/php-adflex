<?php

namespace MadisonSolutions\Adflex;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

/**
 * Represents an attempt to make a payment through Adflex.
 *
 * The intention is that the shop platform will create PaymentAttempt objects directly
 * when the details have been finalised (IE total amount and billing address are known).
 */
class PaymentAttempt extends ImmutableBaseObj
{
    /**
     * Utility function to generate a random unique transaction ref
     */
    protected static function newRandomRef()
    {
        $ref = 'AT'.date('ym');
        $chars = 'abcdefghjkmnpqrstuvwxyz';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < 6; $i++) {
            $ref .= $chars[random_int(0, $max)];
        };
        return $ref;
    }

    /**
     * Create a PaymentAttempt instance
     *
     * @param array $data Array of payment data, which can have the following keys
     *                    - guid : optional, UUID for the transaction, if omitted a random UUID will be generated
     *                    - ref : optional, string 12 chars or less, transaction ref, if ommitted a ref will be generated
     *                    - currency : required, string, 3 char currenct code
     *                    - amount: required, integer, amount of the payment, in the smallest unit of the currency, eg cents or pence
     *                    - description: required, string, description of the payment
     * @throws InvalidArgumentException If the data is not valid
     */
    public function __construct(array $data)
    {
        if (! isset($data['guid'])) {
            $data['guid'] = Uuid::uuid4();
        }
        if (! isset($data['ref'])) {
            $data['ref'] = self::newRandomRef();
        }
        $this->populate($data);
    }

    /**
     * Populate this object with data
     *
     * @param array $data Array of payment data
     * @throws InvalidArgumentException If the data is not valid
     */
    protected function populate(array $data)
    {
        $data = [
            'guid' => $data['guid'] ?? null,
            'ref' => $data['ref'] ?? null,
            'currency' => $data['currency'] ?? null,
            'amount' => $data['amount'] ?? null,
            'description' => $data['description'] ?? null,
            'billing_street' => $data['billing_street'] ?? null,
            'billing_postcode' => $data['billing_postcode'] ?? null,
            'billing_country_code' => $data['billing_country_code'] ?? null,
        ];

        Assert::uuid($data['guid']);
        Assert::stringNotEmpty($data['ref']);
        Assert::maxLength($data['ref'], 12);
        Assert::stringNotEmpty($data['currency']);
        $data['currency'] = strtoupper($data['currency']);
        Assert::oneOf($data['currency'], Currency::allCodes());
        Assert::integer($data['amount']);
        Assert::greaterThan($data['amount'], 0);
        Assert::stringNotEmpty($data['description']);
        Assert::nullOrStringNotEmpty($data['billing_street']);
        Assert::nullOrStringNotEmpty($data['billing_postcode']);
        Assert::nullOrStringNotEmpty($data['billing_country_code']);
        if ($data['billing_country_code']) {
            $data['billing_country_code'] = strtoupper($data['billing_country_code']);
            Assert::oneOf($data['billing_country_code'], Country::allIso3Codes());
        }

        $this->data = $data;
    }
}
