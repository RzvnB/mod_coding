<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Internal library of functions for module coding
 *
 * All the coding specific functions, needed to implement the module
 * logic, should go here. Never include this file from your lib.php!
 *
 * @package    mod_coding
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/*
 * Does something really useful with the passed things
 *
 * @param array $things
 * @return object
 *function coding_do_something_useful(array $things) {
 *    return new stdClass();
 *}
 */

class coding {
    public function view($action='', $args = array()) {
        global $PAGE;
        global $OUTPUT;

        $o = '';
        $o .= $OUTPUT->heading('Monaco Editor Sample');
        $o .= $this->view_editor();

        if ($action == 'result') {
            $o .= $this->view_result();
        }

        $o .= $OUTPUT->footer();
        return $o;
    }

    protected function view_editor() {
        $o = '';
        $o .= html_writer::div('hello world');
        return $o;
    }

    protected function view_result() {
        $o = '';
        $o .= html_writer::div('hello world');
        return $o;
    }
}