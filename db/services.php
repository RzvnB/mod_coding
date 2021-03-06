<?php

$functions = array(
    'mod_coding_compile' => array(         //web service function name
        'classname'   => 'mod_coding_external',  //class containing the external function
        'methodname'  => 'compile',          //external function name
        'classpath'   => 'mod/coding/externallib.php',  //file containing the class/external function
        'description' => 'Compile the program. Run the tests. Return the results.',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax'        => true,
        'services' => array()   
    ),
);
