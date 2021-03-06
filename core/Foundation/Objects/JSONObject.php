<?php

namespace AddPay\Foundation\Objects;

class JSONObject
{
    /**
     * Container for the object data.
     *
     * @var array
     */
    public $resource;

    /**
     * Container for the API protocol/service instantiation.
     *
     * @var mixed
     */
    public $protocol;

    public function __construct(array $data, $protocol = false)
    {
        $this->resource = $data;
        $this->protocol = $protocol;
    }

    /**
     * Returns true if the expected JSON result is found.
     *
     * @return boolean
     */
    public function gotExpectedResult()
    {
        return (isset($this->resource['meta']) && substr($this->resource['meta']['code'], 0, 1) == '2');
    }

    /**
     * An alias for gotExpectedResult().
     *
     * @return boolean
     */
    public function succeeds()
    {
        return $this->gotExpectedResult();
    }

    /**
     * Returns true if the expected JSON result is not found.
     *
     * @return boolean
     */
    public function fails()
    {
        return !$this->succeeds();
    }

    /**
     * Retreive the HTTP response code.
     *
     * @return int
     */
    public function getErrorCode()
    {
        return $this->fails() && isset($this->resource['meta']['code']) ? $this->resource['meta']['code'] : '';
    }

    /**
     * Retreive the HTTP payload message.
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->fails() && isset($this->resource['meta']['message']) ? $this->resource['meta']['message'] : '';
    }

    /**
     * Magic method that catches undefined functions
     * looks for custom magic method and returns the
     * result.
     *
     * An exception is thrown is the function does not exist
     * and it is not a magic method.
     *
     * @return mixed
     */
    public function __call($name, $args)
    {
        if (substr($name, 0, 4) == 'with') {
            $arr = preg_split('/(?=[A-Z])/', substr($name, 4));
            $count = 0;
            $max = count($arr);

            $temp = &$this->resource;
            foreach ($arr as $key) {
                $count++;
                if (strlen($key)) {
                    $temp = &$temp[strtolower($key)];
                }

                if ($count == $max) {
                    $temp = $args[0];
                }
            }
            unset($temp);

            return $this;
        } elseif ((substr($name, 0, 3) == 'get')) {
            $arr = preg_split('/(?=[A-Z])/', substr($name, 3));
            $arr = array_filter($arr, function ($item) {
                return strlen($item);
            });

            $spair = strtolower(implode('', $arr));

            $ritit = new \RecursiveIteratorIterator(new \RecursiveArrayIterator(isset($this->resource['data']) ? $this->resource['data'] : $this->resource));

            $result = null;

            foreach ($ritit as $leafValue) {
                $keys = array();

                foreach (range(0, $ritit->getDepth()) as $depth) {
                    $keys[] = $ritit->getSubIterator($depth)->key();

                    $pair = strtolower(implode('', $keys));

                    if ($pair == $spair) {
                        $result = $ritit->getSubIterator($depth)->current();
                        break;
                    }
                }

                if (!is_null($result)) {
                    break;
                }
            }

            return $result;
        } else {
            if ($this->protocol) {
                return $this->protocol->{$name}(...$args);
            } else {
                throw new \Exception("You're doing it wrong. Read the documentation.");
            }
        }
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Sets the amount currency_code value.
     *
     * @return void
     */
    public function withAmountCurrencyCode($code)
    {
        $this->resource['amount']['currency_code'] = $code;

        return $this;
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Sets the contract notify_url value.
     *
     * @return void
     */
    public function withNotifyUrl($notifyUrl)
    {
        $this->resource['notify_url'] = $notifyUrl;

        return $this;
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Sets the contract return_url value.
     *
     * @return void
     */
    public function withReturnUrl($returnUrl)
    {
        $this->resource['return_url'] = $returnUrl;

        return $this;
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Sets the contract max_amount value.
     *
     * @return void
     */
    public function withContractMaxAmount($amount)
    {
        $this->resource['contract']['max_amount'] = $amount;

        return $this;
    }
    
    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Sets the contract action_day value.
     *
     * @return void
     */
    public function withContractActionDay($day)
    {
        $this->resource['contract']['action_day'] = $day;

        return $this;
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Sets the initiates_at value.
     *
     * @return void
     */
    public function withInitiatesAt($date)
    {
        $this->resource['initiates_at'] = $date;

        return $this;
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Sets the instrument expiry_month value.
     *
     * @return void
     */
    public function withInstrumentExpiryMonth($month)
    {
        $this->resource['instrument']['expiry_month'] = $month;

        return $this;
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Sets the instrument expiry_year value.
     *
     * @return void
     */
    public function withInstrumentExpiryYear($year)
    {
        $this->resource['instrument']['expiry_year'] = $year;

        return $this;
    }

    /**
     * Returns the entire resource object
     *
     * @return mixed
     */
    public function all()
    {
        return isset($this->resource['data']) ? $this->resource['data'] : null;
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Returns the status_reason value if it exists in the object.
     *
     * @return string
     */
    public function getStatusReason()
    {
        return isset($this->resource['status_reason']) ? $this->resource['status_reason'] : null;
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Returns the initiates_at value if it exists in the object.
     *
     * @return string
     */
    public function getInitiatesAt()
    {
        return isset($this->resource['initiates_at']) ? $this->resource['initiates_at'] : null;
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Returns the completed_at value if it exists in the object.
     *
     * @return string
     */
    public function getCompletedAt()
    {
        return isset($this->resource['completed_at']) ? $this->resource['completed_at'] : null;
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Returns the return_url value if it exists in the object.
     *
     * @return string
     */
    public function getReturnUrl()
    {
        return isset($this->resource['return_url']) ? $this->resource['return_url'] : null;
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Returns the notify_url value if it exists in the object.
     *
     * @return string
     */
    public function getNotifyUrl()
    {
        return isset($this->resource['notify_url']) ? $this->resource['notify_url'] : null;
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Returns the call_to_action value if it exists in the object.
     *
     * @return string
     */
    public function getCallToAction()
    {
        return isset($this->resource['call_to_action']) ? $this->resource['call_to_action'] : null;
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Returns the call_to_action URL if it exists in the object.
     *
     * @return string
     */
    public function getCallToActionUrl()
    {
        return isset($this->resource['call_to_action']['url']) ? $this->resource['call_to_action']['url'] : null;
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Returns the call_to_action type if it exists in the object.
     *
     * @return string
     */
    public function getCallToActionType()
    {
        return isset($this->resource['call_to_action']['type']) ? $this->resource['call_to_action']['type'] : null;
    }

    /**
     * Primary function fix to avoid magic method returning incorrect value
     *
     * Returns the call_to_action method if it exists in the object.
     *
     * @return string
     */
    public function getCallToActionMethod()
    {
        return isset($this->resource['call_to_action']['method']) ? $this->resource['call_to_action']['method'] : null;
    }

    /**
     * Helper function to identify status of a transaction,
     * returns true if the status is equal to the passed value.
     *
     * @return boolean
     *
     */
    public function statusIs($status)
    {
        return isset($this->resource['status']) && $status == $this->resource['status'];
    }
}
