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
 * The main coding configuration form
 *
 * It uses the standard core Moodle formslib. For more info about them, please
 * visit: http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * @package    mod_coding
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');

/**
 * Module instance settings form
 *
 * @package    mod_coding
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_coding_mod_form extends moodleform_mod {

    /**
     * Defines forms elements
     */
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        $availableLanguages = array(
            'java' => 'java', 
            'clang' => 'c'
        );

        $mform->addElement('header', 'general', get_string('general', 'coding'));
        
        //Add tests editors
        $mform->addElement('editor', 'visibletests_editor', get_string('visibletests', 'coding'), array('rows' => 10), array('maxfiles' => EDITOR_UNLIMITED_FILES,
        'noclean' => true, 'context' => $this->context, 'subdirs' => true));
        $mform->setType('visibletests', PARAM_RAW); 
        
        $mform->addElement('editor', 'hiddentests', get_string('hiddentests', 'coding'),  array('rows' => 10), array('maxfiles' => EDITOR_UNLIMITED_FILES,
        'noclean' => true, 'context' => $this->context, 'subdirs' => true));
        $mform->setType('hiddentests', PARAM_RAW); 
        
        // Adding the standard "name" field.
        $mform->addElement('text', 'name', get_string('codingname', 'coding'), array('size' => '64'));
        
        $mform->addElement('select', 'lang', 'Select language: ', $availableLanguages);
        // $mform->addElement('text', 'lang', 'language', array('size' => '64'));
        $mform->setType('lang', PARAM_TEXT);
        $mform->addRule('lang', null, 'required', null, 'client');
        
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'codingname', 'coding');

        // Adding the standard "intro" and "introformat" fields.
        if ($CFG->branch >= 29) {
            $this->standard_intro_elements();
        } else {
            $this->add_intro_editor();
        }

        // Adding the rest of coding settings, spreading all them into this fieldset
        // ... or adding more fieldsets ('header' elements) if needed for better logic.
        $mform->addElement('static', 'label1', 'codingsetting1', 'Your coding fields go here. Replace me!');

        $mform->addElement('header', 'codingfieldset', get_string('codingfieldset', 'coding'));
        $mform->addElement('static', 'label2', 'codingsetting2', 'Your coding fields go here. Replace me!');

        // Add standard grading elements.
        $this->standard_grading_coursemodule_elements();

        // Add standard elements, common to all modules.
        $this->standard_coursemodule_elements();

        // Add standard buttons, common to all modules.
        $this->add_action_buttons();
    }
}
