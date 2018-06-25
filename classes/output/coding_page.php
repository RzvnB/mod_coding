<?php

namespace mod_coding\output;

require_once("$CFG->dirroot/webservice/externallib.php");
use renderable;
use templatable;
use renderer_base;
use stdClass;

class coding_page implements renderable, templatable {

    private $language;
    private $input;
    private $output;

    public function __construct($language, $input, $output) {
        $this->language = $language;
        $this->input = $input;
        $this->output = $output;
    }
    
    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {
        error_log("The output in coding page is " . var_export($this->output, true));
        $data = [ 'language' => $this->language,
                  'output' => $this->output,
                  'input' => $this->input ];
        return $data;
    }
}