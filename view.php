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
 * Prints a particular instance of coding
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_coding
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace coding with the name of your module and remove this line.

// use \mod_coding\output\renderer;

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once($CFG->dirroot . '/mod/coding/locallib.php');

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... coding instance ID - it should be named as the first character of the module.

if ($id) {
    $cm         = get_coursemodule_from_id('coding', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $coding  = $DB->get_record('coding', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $coding  = $DB->get_record('coding', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $coding->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('coding', $coding->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

// $columns = $DB->get_columns('coding');
// error_log("The columns are " . var_export($columns, true));

error_log("the coding object is " . var_export($coding, true));

require_login($course, true, $cm);

$event = \mod_coding\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $coding);
$event->trigger();

// $coding = new coding();


$urlparams = array('id' => $cm->id,
'action' => optional_param('action', '', PARAM_ALPHA));

// Print the page header.

$PAGE->set_url('/mod/coding/view.php', $urlparams);
$PAGE->set_title(format_string($coding->name));
$PAGE->set_heading(format_string($course->fullname));
$renderer = $PAGE->get_renderer('mod_coding');
// $renderer = new \mod_coding\output\renderer();

/*
* Other things you may want to set - remove if not needed.
* $PAGE->set_cacheable(false);
* $PAGE->set_focuscontrol('some-html-id');
* $PAGE->add_body_class('coding-'.$somevar);
*/

// Output starts here.
// $PAGE->requires->css('/node_modules/codemirror/lib/codemirror.css');
echo $renderer->header();

$language = $coding->lang;
$page = new \mod_coding\output\coding_page($language);
// Conditions to show the intro can change to look for own settings or whatever.
// if ($coding->intro) {
//     echo $OUTPUT->box(format_module_intro('coding', $coding, $cm->id), 'generalbox mod_introbox', 'codingintro');
// }

// Replace the following lines with you own code.
echo $OUTPUT->heading('Monaco Editor Sample');
// echo $OUTPUT->div('hello world', '' , array());
// echo html_writer::div('hello world');
echo html_writer::div('', '',  array('id' => 'container', 'style' => 'width:800px;height:500px;border:1px solid grey'));
echo $renderer->render_codingpage($page);

// echo html_writer::script('', '../../node_modules/monaco-editor/dev/vs/loader.js');
// $PAGE->requires->js_call_amd('mod_coding/refresh', 'hello');
// echo html_writer::script('', '../../local/js/saveRequire.js');
// echo html_writer::script('', '../../local/js/restoreRequire.js');
// echo html_writer::script('', '../../local/js/codeeditor.js');
// echo $coding->view(optional_param('action', '', PARAM_ALPHA));
// Finish the page.
echo $renderer->footer();
