<?php

    /**
     * Convert under_score type array's keys to camelCase type array's keys
     * @param   array   $array          array to convert
     * @param   array   $arrayHolder    parent array holder for recursive array
     * @return  array   camelCase array
     */
    public function camelCaseKeys($array, $arrayHolder = array()) {
        $camelCaseArray = !empty($arrayHolder) ? $arrayHolder : array();
        foreach ($array as $key => $val) {
            $newKey = @explode('_', $key);
            array_walk($newKey, create_function('&$v', '$v = ucwords($v);'));
            $newKey = @implode('', $newKey);
            $newKey{0} = strtolower($newKey{0});
            if (!is_array($val)) {
                $camelCaseArray[$newKey] = $val;
            } else {
                $camelCaseArray[$newKey] = $this->camelCaseKeys($val, $camelCaseArray[$newKey]);
            }
        }
        return $camelCaseArray;
    }

    /**
     * Convert camelCase type array's keys to under_score+lowercase type array's keys
     * @param   array   $array          array to convert
     * @param   array   $arrayHolder    parent array holder for recursive array
     * @return  array   under_score array
     */
    public function underscoreKeys($array, $arrayHolder = array()) {
        $underscoreArray = !empty($arrayHolder) ? $arrayHolder : array();
        foreach ($array as $key => $val) {
            $newKey = preg_replace('/[A-Z]/', '_$0', $key);
            $newKey = strtolower($newKey);
            $newKey = ltrim($newKey, '_');
            if (!is_array($val)) {
                $underscoreArray[$newKey] = $val;
            } else {
                $underscoreArray[$newKey] = $this->underscoreKeys($val, $underscoreArray[$newKey]);
            }
        }
        return $underscoreArray;
    }

    /**
     * Convert camelCase type array's values to under_score+lowercase type array's values
     * @param   mixed   $mixed          array|string to convert
     * @param   array   $arrayHolder    parent array holder for recursive array
     * @return  mixed   under_score array|string
     */
    public function underscoreValues($mixed, $arrayHolder = array()) {
        $underscoreArray = !empty($arrayHolder) ? $arrayHolder : array();
        if (!is_array($mixed)) {
            $newVal = preg_replace('/[A-Z]/', '_$0', $mixed);
            $newVal = strtolower($newVal);
            $newVal = ltrim($newVal, '_');
            return $newVal;
        } else {
            foreach ($mixed as $key => $val) {
                $underscoreArray[$key] = $this->underscoreValues($val, $underscoreArray[$key]);
            }
            return $underscoreArray;
        }
    }