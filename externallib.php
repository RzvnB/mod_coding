<?php

require_once("$CFG->libdir/externallib.php");

class mod_coding_external extends external_api {

    /**
        * Returns description of method parameters
        * @return external_function_parameters
    */
    public static function compile_parameters() {
        return new external_function_parameters(
            array(
                'code' => new external_value(PARAM_RAW, 'The code to be compiled'),
                'language' => new external_value(PARAM_RAW, 'The programming language to be used for compiling')
            )
        );
    }


    /**
        * Returns description of method result value
        * @return external_description
    */
    public static function compile_returns() {
        // return new external_value(PARAM_TEXT, 'The result of the compiled code');
        return new external_single_structure(
            array(
                'compile_result' => new external_value(PARAM_RAW, 'Compile result'),
            )
        );
    }

    public static function compile($code, $language) {
        global $USER;
        
        $rawParams = array(
            'code' => $code,
            'language' => $language
        );
        
        $params = self::validate_parameters(self::compile_parameters(), $rawParams);
        $context = context_user::instance($USER->id);
        self::validate_context($context);
        
        $sandbox = new mod_coding_sandbox($code, $language);
        $output = $sandbox->run();
        
        $ret = array();
        $ret['compile_result'] = $output;
        return $ret;
    }

}