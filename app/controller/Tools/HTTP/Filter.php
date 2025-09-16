<?php

namespace TOOL\HTTP;

class Filter
{

    /**
     * IS_EMAIL
     * 
     * @var string
     */
    const IS_EMAIL = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";

    /**
     * IS_USERNAME
     * 
     * @var string
     */
    const IS_USERNAME = "/^[a-z\d_]{2,20}$/i";

    /**
     * IS_POSITIVE_NUMBER
     * 
     * @var array
     */
    const IS_POSITIVE_NUMBER = [
        'filter' => FILTER_VALIDATE_FLOAT,
        'args' => [
            'options' =>  [
                'min_range' => 0,
            ]
        ]
    ];

    /**
     * IS_ID
     * 
     * @var array
     */
    const IS_ID = [
        'filter' => FILTER_VALIDATE_INT,
        'args' => [
            'options' =>  [
                'min_range' => 1,
            ]
        ]
    ];


    /**
     * Valid
     * 
     * @var array
     */
    public $valid;

    /**
     * Invalid
     * 
     * @var array
     */
    public array $invalid;


    /**
     * Filter __construct
     * 
     * @param array $valid
     * 
     * @param array $invalid
     */
    private function __construct(array $valid, array $invalid)
    {

        $this->valid = $valid;
        $this->invalid = $invalid;
    }

    /**
     * Throw method
     * 
     * @param ?string $message
     * 
     * @return self
     */
    function throw(?string $message = null)
    {

        // Check invalid
        if (!$this->invalid)
            return $this;

        // Message
        if (!$message) {
            foreach ($this->invalid as $param) {
                if ($param[0]) {
                    $message = $param[0];
                    break;
                }
            }
        }

        throw new RESException($message, RES::INVALID, $this->invalid);
    }

    /**
     * Validate method
     * 
     * @param array $parameters
     * 
     * @return self
     */
    static function validate(array $parameters)
    {

        // Valid
        $valid = [];

        // Invalid
        $invalid = [];

        # Filter parameters
        foreach ($parameters as $properties) {

            # Generete Filter
            $isFilter = TRUE;

            # Check is invalid before
            if (isset($invalid[$properties[0]]))
                continue;

            # Null value
            if ($properties[1] === '')
                $properties[1] = null;

            $nullValue = is_null($properties[1]);

            # Just value
            if ($nullValue && $properties[2] === TRUE)
                $isFilter = FALSE;

            else if (($properties[2] === TRUE || !$nullValue) && isset($properties[3])) {

                # Parameter with filter and options
                if (is_array($properties[3]))

                    $isFilter = filter_var(
                        $properties[1],
                        $properties[3]['filter'],
                        $properties[3]['args']
                    );

                # Parameter as preg match
                else if (is_string($properties[3]))
                    $isFilter = (bool) preg_match($properties[3], $properties[1]);

                # Parameter as callable
                else if (is_callable($properties[3]))
                    $isFilter = (bool) ($properties[3])((object) $valid);

                # Parameter as bool
                else if (is_bool($properties[3]))
                    $isFilter = (bool) $properties[3];

                # Parameter with filter int
                else if (is_int($properties[3]))

                    $isFilter = filter_var(
                        $properties[1],
                        $properties[3]
                    );

                // Is null
                else
                    $isFilter = true;
            }


            # Chek is valid
            if ($isFilter === false) {
                $invalid[$properties[0]] = [...(array) $invalid[$properties[0]], $properties[4]];

                # remove from valid if exist
                unset($valid[$properties[0]]);
            } else if (!$invalid[$properties[0]])
                $valid[$properties[0]] = $properties[1];
        }

        return new self($valid, $invalid);
    }

    /**
     * Multi validate method
     * 
     * @param callable $filter
     * 
     * @param array $rows
     * 
     * @return self
     */
    static function multiValidate(callable $filter, array $rows)
    {

        // Define parameters
        $parameters = array_map(function ($row) use ($filter) {
            return $filter((object) $row);
        }, $rows);

        // Valid
        $valid = [];

        // Invalid
        $invalid = [];

        // Verfiy requests
        foreach ($parameters as $index => $parameter) {

            // Check found parameter
            if ($parameter === false)
                continue;

            $Filter = self::validate($parameter);

            // Invalid
            if ($Filter->invalid)

                $invalid[$index] = $Filter->invalid;

            // Valid
            else

                $valid[$index] = $Filter->valid;
        }

        return new self($valid, $invalid);
    }

    /** 
     * Use method
     * 
     * @param array $parameters
     * 
     * @param array $needly
     * 
     * @return array
     */
    static function use(array $parameters, array $needly)
    {

        return array_filter($parameters, function ($value) use ($needly) {

            return in_array($value, $needly);
        }, ARRAY_FILTER_USE_KEY);
    }
}
