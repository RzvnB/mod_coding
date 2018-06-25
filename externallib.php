<?php

require_once("$CFG->libdir/externallib.php");

class mod_coding_external extends external_api {

    public static function compile_parameters() {
        return new external_function_parameters(
            array(
                'code' => new external_value(PARAM_RAW, 'The code to be compiled'),
                'language' => new external_value(PARAM_TEXT, 'The programming language to be used for compiling'),
                'input' => new external_value(PARAM_RAW, 'The input for the visible test')
            )
        );
    }
 
    public static function compile_returns() {
        return new external_single_structure(
            array(
                'compile_result' => new external_value(PARAM_RAW, 'Compile result'),
            )
        );
    }

    public static function compile($code, $language, $input) {
        global $USER;
        
        $rawParams = array(
            'code' => $code,
            'language' => $language,
            'input' => $input
        );
        
        $params = self::validate_parameters(self::compile_parameters(), $rawParams);
        $context = context_user::instance($USER->id);
        self::validate_context($context);
        
        error_log("The input in externallib is " . var_export($input, true));
        $sandbox = new mod_coding_sandbox($code, $language, $input);
        $output = $sandbox->run();
        
        
        $ret = array();
        $ret['compile_result'] = $output;
        return $ret;
    }

}