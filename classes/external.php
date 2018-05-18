<?php

namespace mod_coding;

require_once("$CFG->libdir/externallib.php");
require_once("$CFG->dirroot/webservice/externallib.php");
use external_api;
use external_function_parameters;
use external_value;
use external_format_value;
use external_single_structure;
use external_multiple_structure;
use invalid_parameter_exception;

class external extends external_api {
        /**
        * Returns description of method parameters
        * @return external_function_parameters
    */
    public static function compile_parameters() {
        return new external_function_parameters(
            array('welcomemessage' => new external_value(PARAM_TEXT, 'The welcome message. By default it is "Hello world,"', VALUE_DEFAULT, 'Hello world, '))
        );
    }


    /**
        * Returns description of method result value
        * @return external_description
    */
    public static function compile_returns() {
        return new external_value(PARAM_TEXT, 'The welcome message + user first name');
    }

    public static function compile($welcomemessage) {
        global $USER;

        $params = self::validate_parameters(self::compile_parameters(), array('welcomemessage' => $welcomemessage));
        $context = get_context_instance(CONTEXT_USER, $USER->id);
        self::validate_context($context);
        
        return $params['welcomemessage'] . $USER->firstname;

    }

}
