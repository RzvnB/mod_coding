<?php

namespace mod_coding\output;

require_once("$CFG->dirroot/webservice/externallib.php");
use renderable;
use templatable;
use renderer_base;
use stdClass;

class coding_page implements renderable, templatable {

    private $language;

    public function __construct($language) {
        $this->language = $language;
    }
    
    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {
        $data = [ 'language' => $this->language ];
        // $data = \mod_webservice_external::compile();
        return $data;
    }
}