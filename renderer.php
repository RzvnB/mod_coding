<?php

defined('MOODLE_INTERNAL') || die;

class mod_coding_renderer extends plugin_renderer_base {
    
    public function render_codingpage($page) {
        $data = $page->export_for_template($this);
        return parent::render_from_template('mod_coding/coding', $data);
    }
    
}