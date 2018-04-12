<?php

/**
 * @author Prima Noor
 * @copyright 2011
 * @uses Key.class.php on module/core.lang.key
 */

class GT_Validation
{

    var $_field_data = array();
    var $_config_rules = array();
    var $_error_array = array();
    var $_error_messages = array();
    var $_error_prefix = '<p>';
    var $_error_suffix = '</p>';
    var $error_string = '';
    var $_safe_form_data = false;
    var $_msg = array();
    var $post = array();

    /**
     * constructor
     */
    function __construct()
    {
        $lang = GtfwLang()->GetLangCode();
        $ObjKey = GtfwDispt()->load->business('Key', 'core.lang.key');
        $this->_msg = $ObjKey->getKeyByPrefix('validation_');                
        $this->post = $_POST->AsArray();
    }

    /**
     * Set Error Message
     *
     * Lets users set their own error messages on the fly.  Note:  The key
     * name has to match the  function name that it corresponds to.
     *
     * @access	public
     * @param	string
     * @param	string
     * @return	string
     */
    function set_message($lang, $val = '')
    {
        if (!is_array($lang)) {
            $lang = array($lang => $val);
        }

        $this->_error_messages = array_merge($this->_error_messages, $lang);

        return $this;
    }

    /**
     * Set Rules
     *
     * This function takes an array of field names and validation
     * rules as input, validates the info, and stores it
     *
     * @access	public
     * @param	mixed
     * @param	string
     * @return	void
     */
    function set_rules($field, $label = '', $rules = '')
    {
        // No reason to set rules if we have no POST data
        if (count($this->post) == 0) {
            return $this;
        }

        // If an array was passed via the first parameter instead of indidual string
        // values we cycle through it and recursively call this function.
        if (is_array($field)) {
            foreach ($field as $row) {
                // Houston, we have a problem...
                if (!isset($row['field']) or !isset($row['rules'])) {
                    continue;
                }

                // If the field label wasn't passed we use the field name
                $label = (!isset($row['label'])) ? $row['field'] : $row['label'];

                // Here we go!
                $this->set_rules($row['field'], $label, $row['rules']);
            }
            return $this;
        }

        // No fields? Nothing to do...
        if (!is_string($field) or !is_string($rules) or $field == '') {
            return $this;
        }

        // If the field label wasn't passed we use the field name
        $label = ($label == '') ? $field : $label;

        // Is the field name an array?  We test for the existence of a bracket "[" in
        // the field name to determine this.  If it is an array, we break it apart
        // into its components so that we can fetch the corresponding POST data later
        if (strpos($field, '[') !== false and preg_match_all('/\[(.*?)\]/', $field, $matches)) {
            // Note: Due to a bug in current() that affects some versions
            // of PHP we can not pass function call directly into it
            $x = explode('[', $field);
            $indexes[] = current($x);

            for ($i = 0; $i < count($matches['0']); $i++) {
                if ($matches['1'][$i] != '') {
                    $indexes[] = $matches['1'][$i];
                }
            }

            $is_array = true;
        } else {
            $indexes = array();
            $is_array = false;
        }

        // Build our master array
        $this->_field_data[$field] = array(
            'field' => $field,
            'label' => $label,
            'rules' => $rules,
            'is_array' => $is_array,
            'keys' => $indexes,
            'postdata' => null,
            'error' => '');
        return $this;
    }

    /**
     * Get Error Message
     *
     * Gets the error message associated with a particular field
     *
     * @access	public
     * @param	string	the field name
     * @return	void
     */
    function error($field = '', $prefix = '', $suffix = '')
    {
        if (!isset($this->_field_data[$field]['error']) or $this->_field_data[$field]['error'] == '') {
            return '';
        }

        if ($prefix == '') {
            $prefix = $this->_error_prefix;
        }

        if ($suffix == '') {
            $suffix = $this->_error_suffix;
        }

        return $prefix . $this->_field_data[$field]['error'] . $suffix;
    }


    /**
     * Error String
     *
     * Returns the error messages as a string, wrapped in the error delimiters
     *
     * @access	public
     * @param	string
     * @param	string
     * @return	str
     */
    function error_string($prefix = '', $suffix = '')
    {
        // No errrors, validation passes!
        if (count($this->_error_array) === 0) {
            return '';
        }

        if ($prefix == '') {
            $prefix = $this->_error_prefix;
        }

        if ($suffix == '') {
            $suffix = $this->_error_suffix;
        }

        // Generate the error string
        $str = '';
        foreach ($this->_error_array as $val) {
            if ($val != '') {
                $str .= $prefix . $val . $suffix . "\n";
            }
        }

        return $str;
    }

    /**
     * Run the Validator
     *
     * This function does all the work.
     *
     * @access	public
     * @return	bool
     */
    function run()
    {
        // Do we even have any data to process?  Mm?
        if (count($this->post) == 0) {
            return false;
        }

        // Cycle through the rules for each field, match the
        // corresponding $this->post item and test for errors
        foreach ($this->_field_data as $field => $row) {
            // Fetch the data from the corresponding $this->post array and cache it in the _field_data array.
            // Depending on whether the field name is an array or a string will determine where we get it from.

            if ($row['is_array'] == true) {
                $this->_field_data[$field]['postdata'] = $this->_reduce_array($this->post, $row['keys']);
            } else {
                if (isset($this->post[$field]) and $this->post[$field] != "") {
                    $this->_field_data[$field]['postdata'] = $this->post[$field];
                }
            }
            $this->_execute($row, explode('|', $row['rules']), $this->_field_data[$field]['postdata']);
        }

        // Did we end up with any errors?
        $total_errors = count($this->_error_array);

        if ($total_errors > 0) {
            $this->_safe_form_data = true;
        }

        // Now we need to re-set the POST data with the new, processed data
        $this->_reset_post_array();

        // No errors, validation passes!
        if ($total_errors == 0) {
            return true;
        }

        // Validation fails
        return false;
    }

    /**
     * Executes the Validation routines
     *
     * @access	private
     * @param	array
     * @param	array
     * @param	mixed
     * @param	integer
     * @return	mixed
     */
    function _execute($row, $rules, $postdata = null, $cycles = 0)
    {
        // If the field is blank, but NOT required, no further tests are necessary
        $callback = false;
        if (!in_array('required', $rules) and is_null($postdata)) {
            // Before we bail out, does the rule contain a callback?
            if (preg_match("/(callback_\w+)/", implode(' ', $rules), $match)) {
                $callback = true;
                $rules = (array('1' => $match[1]));
            } else {
                return;
            }
        }

        // --------------------------------------------------------------------

        // Cycle through each rule and run it

        foreach ($rules as $rule) {
            $_in_array = false;

            // We set the $postdata variable with the current data in our master array so that
            // each cycle of the loop is dealing with the processed data from the last cycle
            if ($row['is_array'] == true and is_array($this->_field_data[$row['field']]['postdata'])) {
                // We shouldn't need this safety, but just in case there isn't an array index
                // associated with this cycle we'll bail out
                if (!isset($this->_field_data[$row['field']]['postdata'][$cycles])) {
                    continue;
                }

                $postdata = $this->_field_data[$row['field']]['postdata'][$cycles];
                $_in_array = true;
            } else {
                $postdata = $this->_field_data[$row['field']]['postdata'];
            }

            // --------------------------------------------------------------------
            // Is the rule a callback?
            $callback = false;
            if (substr($rule, 0, 9) == 'callback_') {
                $rule = substr($rule, 9);
                $callback = true;
            }
            // Strip the parameter (if exists) from the rule
            // Rules can contain a parameter: max_length[5]
            $param = false;
            if (preg_match("/(.*?)\[(.*)\]/", $rule, $match)) {
                $rule = $match[1];
                $param = $match[2];
            }

            // Call the function that corresponds to the rule
            if ($callback === true) {
                // Run the function and grab the result
                $result = $this->$rule($postdata, $param);

                // Re-assign the result to the master data array
                if ($_in_array == true) {
                    $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                } else {
                    $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                }

                // If the field isn't required and we just processed a callback we'll move on...
                if (!in_array('required', $rules, true) and $result !== false) {
                    continue;
                }
            } else {
                if (!method_exists($this, $rule)) {
                    // If our own wrapper function doesn't exist we see if a native PHP function does.
                    // Users can use any native PHP function call that has one param.
                    if (function_exists($rule)) {
                        $result = $rule($postdata);

                        if ($_in_array == true) {
                            $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                        } else {
                            $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                        }
                    }

                    continue;
                }

                $result = $this->$rule($postdata, $param);

                if ($_in_array == true) {
                    $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                } else {
                    $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                }
            }

            // Did the rule test negatively?  If so, grab the error.
            if ($result === false) {
                if (!isset($this->_error_messages[$rule])) {
                    if (false === ($line = $this->_msg[$rule])) {
                        $line = 'Unable to access an error message corresponding to your field name.';
                    }
                } else {
                    $line = $this->_error_messages[$rule];
                }

                // Is the parameter we are inserting into the error message the name
                // of another field?  If so we need to grab its "field label"
                if (isset($this->_field_data[$param]) and isset($this->_field_data[$param]['label'])) {
                    $param = $this->_translate_fieldname($this->_field_data[$param]['label']);
                }

                // Build the error message
                $message = sprintf($line, $this->_translate_fieldname($row['label']), $param);

                // Save the error message
                $this->_field_data[$row['field']]['error'] = $message;

                if (!isset($this->_error_array[$row['field']])) {
                    $this->_error_array[$row['field']] = $message;
                }

                return;
            }
        }
    }


    /**
     * Prep data for form
     *
     * This function allows HTML to be safely shown in a form.
     * Special characters are converted.
     *
     * @access	public
     * @param	string
     * @return	string
     */
    function prep_for_form($data = '')
    {
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $data[$key] = $this->prep_for_form($val);
            }

            return $data;
        }

        if ($this->_safe_form_data == false or $data === '') {
            return $data;
        }

        return str_replace(array(
            "'",
            '"',
            '<',
            '>'), array(
            "&#39;",
            "&quot;",
            '&lt;',
            '&gt;'), stripslashes($data));
    }

    /**
     * Translate a field name
     *
     * @access	private
     * @param	string	the field name
     * @return	string
     */
    function _translate_fieldname($fieldname)
    {
        // Do we need to translate the field name?
        // We look for the prefix lang: to determine this
        if (substr($fieldname, 0, 5) == 'lang:') {
            // Grab the variable
            $line = substr($fieldname, 5);

            // Were we able to translate the field name?  If not we use $line
            if (false === ($fieldname = $message($line))) {
                return $line;
            }
        }

        return $fieldname;
    }

    /**
     * Re-populate the _POST array with our finalized and processed data
     *
     * @access	private
     * @return	null
     */
    function _reset_post_array()
    {
        foreach ($this->_field_data as $field => $row) {
            if (!is_null($row['postdata'])) {
                if ($row['is_array'] == false) {
                    if (isset($this->post[$row['field']])) {
                        $this->post[$row['field']] = $this->prep_for_form($row['postdata']);
                    }
                } else {
                    // start with a reference
                    $post_ref = &$this->post;

                    // before we assign values, make a reference to the right POST key
                    if (count($row['keys']) == 1) {
                        $post_ref = &$post_ref[current($row['keys'])];
                    } else {
                        foreach ($row['keys'] as $val) {
                            $post_ref = &$post_ref[$val];
                        }
                    }

                    if (is_array($row['postdata'])) {
                        $array = array();
                        foreach ($row['postdata'] as $k => $v) {
                            $array[$k] = $this->prep_for_form($v);
                        }

                        $post_ref = $array;
                    } else {
                        $post_ref = $this->prep_for_form($row['postdata']);
                    }
                }
            }
        }
    }
    /**
     * Required
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function required($str)
    {
        if (!is_array($str)) {
            return (trim($str) == '') ? false : true;
        } else {
            return (!empty($str));
        }
    }

    // --------------------------------------------------------------------

    /**
     * Performs a Regular Expression match test.
     *
     * @access	public
     * @param	string
     * @param	regex
     * @return	bool
     */
    function regex_match($str, $regex)
    {
        if (!preg_match($regex, $str)) {
            return false;
        }

        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Match one field to another
     *
     * @access	public
     * @param	string
     * @param	field
     * @return	bool
     */
    function matches($str, $field)
    {
        if (!isset($this->post[$field])) {
            return false;
        }

        $field = $this->post[$field];

        return ($str !== $field) ? false : true;
    }

    // --------------------------------------------------------------------

    /** matches_pattern()
     * /* Ensures a string matches a basic pattern
     * /* # numeric, ? alphabetical, ~ any character
     */
    function matches_pattern($str, $pattern)
    {
        $characters = array(
            '[',
            ']',
            '\\',
            '^',
            '$',
            '.',
            '|',
            '+',
            '(',
            ')',
            '#',
            '?',
            '~' // Our additional characters
                );

        $regex_characters = array(
            '\[',
            '\]',
            '\\\\',
            '\^',
            '\$',
            '\.',
            '\|',
            '\+',
            '\(',
            '\)',
            '[0-9]',
            '[a-zA-Z]',
            '.' // Our additional characters
                );

        $pattern = str_replace($characters, $regex_characters, $pattern);
        if (preg_match('/^' . $pattern . '$/', $str))
            return true;
        return false;
    }

    // --------------------------------------------------------------------

    /**
     * Minimum Length
     *
     * @access	public
     * @param	string
     * @param	value
     * @return	bool
     */
    function min_length($str, $val)
    {
        if (preg_match("/[^0-9]/", $val)) {
            return false;
        }

        if (function_exists('mb_strlen')) {
            return (mb_strlen($str) < $val) ? false : true;
        }

        return (strlen($str) < $val) ? false : true;
    }

    // --------------------------------------------------------------------

    /**
     * Max Length
     *
     * @access	public
     * @param	string
     * @param	value
     * @return	bool
     */
    function max_length($str, $val)
    {
        if (preg_match("/[^0-9]/", $val)) {
            return false;
        }

        if (function_exists('mb_strlen')) {
            return (mb_strlen($str) > $val) ? false : true;
        }

        return (strlen($str) > $val) ? false : true;
    }

    // --------------------------------------------------------------------

    /**
     * Exact Length
     *
     * @access	public
     * @param	string
     * @param	value
     * @return	bool
     */
    function exact_length($str, $val)
    {
        if (preg_match("/[^0-9]/", $val)) {
            return false;
        }

        if (function_exists('mb_strlen')) {
            return (mb_strlen($str) != $val) ? false : true;
        }

        return (strlen($str) != $val) ? false : true;
    }

    // --------------------------------------------------------------------

    /**
     * Valid Email
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_email($str)
    {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? false : true;
    }

    // --------------------------------------------------------------------

    /**
     * Valid Emails
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_emails($str)
    {
        if (strpos($str, ',') === false) {
            return $this->valid_email(trim($str));
        }

        foreach (explode(',', $str) as $email) {
            if (trim($email) != '' && $this->valid_email(trim($email)) === false) {
                return false;
            }
        }

        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Validate IP Address
     *
     * @access	public
     * @param	string
     * @return	string
     */
    function valid_ip($ip)
    {
        return $this->CI->input->valid_ip($ip);
    }

    // --------------------------------------------------------------------

    /**
     * Alpha
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function alpha($str)
    {
        return (!preg_match("/^([a-z])+$/i", $str)) ? false : true;
    }

    // --------------------------------------------------------------------

    /**
     * Alpha-numeric
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function alpha_numeric($str)
    {
        return (!preg_match("/^([a-z0-9])+$/i", $str)) ? false : true;
    }

    // --------------------------------------------------------------------

    /**
     * Alpha-numeric with underscores and dashes
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function alpha_dash($str)
    {
        return (!preg_match("/^([-a-z0-9_-])+$/i", $str)) ? false : true;
    }

    // --------------------------------------------------------------------

    /**
     * Numeric
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function numeric($str)
    {
        return (bool)preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $str);

    }

    // --------------------------------------------------------------------

    /**
     * Is Numeric
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function is_numeric($str)
    {
        return (!is_numeric($str)) ? false : true;
    }

    // --------------------------------------------------------------------

    /**
     * Integer
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function integer($str)
    {
        return (bool)preg_match('/^[\-+]?[0-9]+$/', $str);
    }

    // --------------------------------------------------------------------

    /**
     * Is a Natural number  (0,1,2,3, etc.)
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function is_natural($str)
    {
        return (bool)preg_match('/^[0-9]+$/', $str);
    }

    // --------------------------------------------------------------------

    /**
     * Is a Natural number, but not a zero  (1,2,3, etc.)
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function is_natural_no_zero($str)
    {
        if (!preg_match('/^[0-9]+$/', $str)) {
            return false;
        }

        if ($str == 0) {
            return false;
        }

        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Valid Base64
     *
     * Tests a string for characters outside of the Base64 alphabet
     * as defined by RFC 2045 http://www.faqs.org/rfcs/rfc2045
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_base64($str)
    {
        return (bool)!preg_match('/[^a-zA-Z0-9\/\+=]/', $str);
    }
    
    /**
     * external_callbacks method handles form validation callbacks that are not located
     * in the controller where the form validation was run.
     *
     * $param is a comma delimited string where the first value is the name of the model
     * where the callback lives. The second value is the method name, and any additional 
     * values are sent to the method as a one dimensional array.
     *
     * EXAMPLE RULE:
     *  callback_external_callbacks[some_model,some_method,some_string,another_string]
     */
    public function external_callbacks($postdata, $param)
    {
        $param_values = explode(',', $param);

        // Make sure the model is loaded
        $model = trim($param_values[0]);
        $module = trim($param_values[1]);
        
        $ObjModel = GtfwDispt()->load->process($model, $module);
        // Rename the second element in the array for easy usage
        $method = trim($param_values[2]);

        // Check to see if there are any additional values to send as an array
        if (count($param_values) > 3) {
            // Remove the first three elements in the param_values array
            array_shift($param_values);
            array_shift($param_values);
            array_shift($param_values);

            $argument = $param_values;
        }

        // Do the actual validation in the external callback
        if (isset($argument)) {
            $callback_result = $ObjModel->$method($postdata, $argument);
        } else {
            $callback_result = $ObjModel->$method($postdata);
        }
        
        if (!empty($callback_result['message']) AND !$callback_result['result']) {
            $this->set_message('external_callbacks', $callback_result['message']);
        }

        return $callback_result['result'];
    }


}

?>