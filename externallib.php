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
        
        // $task = new \mod_coding\task\test_task();
        
        // \core\task\manager::queue_adhoc_task($task);
        
        $rawParams = array(
            'code' => $code,
            'language' => $language
        );
        
        $params = self::validate_parameters(self::compile_parameters(), $rawParams);
        // $context = get_context_instance(CONTEXT_USER, $USER->id);
        $context = context_user::instance($USER->id);
        self::validate_context($context);

        // $code = $params['code'];
        
        error_log("the lang is " . var_export($language, true));
        $sandbox = new mod_coding_sandbox($code, $language);
        $output = $sandbox->run();

        // $output = shell_exec('touch /tmp/testfile');
        // $code = $params['code'];
        // $command = 'docker run hello-world';
        // $command = 'whoami';
        // $command = 'echo "' . $code . '" > /tmp/testfile';
        // $output = shell_exec($command);
        // exec($command);
        // $output = shell_exec('cat /tmp/file.out');
        // $output = shell_exec('whoami');
        
        // $output = shell_exec('mkdir /tmp/whatever');
        
        $ret = array();
        $ret['compile_result'] = $output;
        return $ret;
        // return $params['welcomemessage'] . $USER->firstname;
        // return $ret;

    }

}