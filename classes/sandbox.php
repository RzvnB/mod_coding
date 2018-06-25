<?php

// defined('MOODLE_INTERNAL') || die();


class mod_coding_sandbox {

    private $code;
    private $language;
    private $input;
    private $timeout;
    private $path;
    private $basePath;
    private $environments;

    public function __construct($code, $language, $input, $timeout=60) {
        global $CFG;
        $this->code = $code;
        $this->language = $language;
        $this->input = $input;
        $this->timeout = $timeout;
        // $this->basePath = $CFG->dirroot . '/mod/coding/temp';
        $this->basePath = '/tmp';
        $this->initEnvironments();
    }
    
    private function initEnvironments() {
        $this->environments = array(
            "clang" => array(
                "fileName" => "file.c",
                "compiler" => "gcc",
                "flags" => "-o app.out -Wall -Werror -std=c99",
                "execCommand" => "/usr/src/app/app.out"
            ),
            "java" => array(
                "fileName" => "file.java",
                "compiler" => "javac",
                "flags" => "",
                "execCommand" => "/usr/scripts/javaRunner.sh"
            )
        );
    }
    
    private function generateDirPath() {
        $dirName = uniqid('workspace_', TRUE);
        return $this->basePath . '/' . $dirName;
    }

    private function createSourceFile() {
        $fileName = $this->environments[$this->language]["fileName"];
        $filePath = $this->path . '/' . $fileName;
        $fileHandle = fopen($filePath, "w") or die("Unable to open file!");
        fwrite($fileHandle, $this->code);
        fclose($fileHandle);
    }
    
    private function createInputFile() {
        $inputFilePath = $this->path . '/input';
        $fileHandle = fopen($inputFilePath, "w") or die ("Unable to open file!");
        
        error_log("The input in sandbox is " . var_export($this->input, true));
        $x = fwrite($fileHandle, $this->input); 
        error_log("Bytes written is " . var_export($x, true));
        fclose($fileHandle);
    }
    
    private function prepareEnvironment() {
        $this->path = $this->generateDirPath();
        if (is_dir($this->path)) {
            $this->path = $this->generateDirPath();
        }
        mkdir($this->path) or die ("Unable to create directory!");
        $this->createSourceFile();
        $this->createInputFile();
    }
    
    private function generateExecCommand($fileName) {
        if ($this->language != "java") {
            return "./" . "app.out";
        }
        return "";
    }

    private function cleanEnvironment() {
        shell_exec("rm -rf " . $this->path);
    }
    
    private function logFileContents() {
        $logFile = $this->path . "/logfile";
        $logLines = file($logFile);
        return implode("", $logLines);
    }

    public function run() {
        $this->prepareEnvironment();
        $fileName = $this->environments[$this->language]["fileName"];
        $compiler = $this->environments[$this->language]["compiler"];
        $flags = $this->environments[$this->language]["flags"];
        $execCommand = $this->environments[$this->language]["execCommand"];
        $dockerImage = "appbuilder4";

        $buildCommand = "/usr/scripts/build.sh " . $this->timeout . " " . $execCommand . " " . $compiler  . " " . $fileName . " " . $flags;
        $command = "docker run --cap-drop=ALL --volume " . $this->path . ":/usr/src/app --rm " . $dockerImage . " " . $buildCommand;
        
        error_log("The command is " . $command);

        $return_var = -1;
        $output = array(); 
        shell_exec($command);
        $logContents = $this->logFileContents();
        // $this->cleanEnvironment();

        return $logContents;
    }
    
}