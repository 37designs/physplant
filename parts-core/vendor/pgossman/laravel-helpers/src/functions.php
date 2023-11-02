<?php

if (! function_exists('displayNotification')) {
    /**
     * Creates HTML & Bootstrap formatted notification box from session data.
     *
     * Looks for "notification" using Laravel's Session facade in the format "{type}|{message content}".
     * {type} can be either "success", "info", "warning", or "danger"; your choice will affect how the alert will appear
     * to the user.
     *
     * Example:
     * Laravel redirect: redirect("/")->with("notification", "alert|Your form failed to submit");
     * Show notification in view: {{!! displayNotification() !!}}
     *
     * @return string HTML formatted alert
     */
    function displayNotification()
    {
        if (\Illuminate\Support\Facades\Session::has("notification")) {
            list($type, $message) = explode('|', \Illuminate\Support\Facades\Session::get("notification"), 2);

            return sprintf('<div class="alert alert-%s">%s</div>', $type, $message);
        }

        return "";
    }
}

if (! function_exists('cleanUsername')) {
    /**
     * Converts to lowercase, trims whitespace, and converts a potential email address to a username by removing anything
     * that comes after an @ symbol.
     *
     * @param string $username
     * @return string
     */
    function cleanUsername($username)
    {
        $usernameArr = explode('@', $username);

        return trim(strtolower($usernameArr[0]));
    }
}

if (! function_exists('allNullValues')) {
    /**
     * Determines if all values in an array are null.
     *
     * @param array $array
     * @return bool
     */
    function allNullValues(array $array)
    {
        foreach ($array as $value) {
            if ($value !== null) {
                return false;
            }
        }

        return true;
    }
}

if (! function_exists('removeNullArrays')) {
    /**
     * Removes sub-arrays whose values are all equal to null. Useful for cleaning request input.
     *
     * @param array $array two-dimensional array
     * @return array
     */
    function removeNullArrays(array $array)
    {
        for ($i = 0; $i < count($array); $i++) {
            if (is_array($array[$i]) && allNullValues($array[$i])) {
                array_splice($array, $i, 1);
                $i--;
            }
        }

        return $array;
    }
}

if (! function_exists('usStates')) {
    /**
     * All US states.
     *
     * @return array
     */
    function usStates()
    {
        return [
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'DC' => 'Washington DC',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'PR' => 'Puerto Rico',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VI' => 'Virgin Islands',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming',
        ];
    }
}
