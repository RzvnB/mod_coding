<?php

defined('MOODLE_INTERNAL') || die;

class mod_coding_renderer extends plugin_renderer_base {
    
    
    public function render_codingpage($page) {
        // global $PAGE;
        // global $OUTPUT;
        
        // $o = '';
        // $o .= $OUTPUT->heading('Monaco Editor Sample');
        // $o .= $this->render_editor();
        
        // if ($action == 'result') {
        //     $o .= $this->render_result();
        // }
        
        // return $o;
        $data = $page->export_for_template($this);
        return parent::render_from_template('mod_coding/coding', $data);
    }
    
}