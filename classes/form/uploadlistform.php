<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     tool_resetpasswords
 * @copyright   2023 Wafaa Hamdy <eng.wafaa.hamdy@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_resetpasswords\form;

defined('MOODLE_INTERNAL') || die();


require_once("$CFG->libdir/formslib.php");


/**
 * class to intiate bulk reset password form
 */
class uploadlistform extends  \moodleform {
    /**
     * function definition
     * @return void
     */
    public function definition () {
        $mform = $this->_form;
        $mform->addElement('header', 'settingsheader', get_string('upload'));

        $url = new \moodle_url('example.csv');
        $link = \html_writer::link($url, 'example.csv');
        $mform->addElement('static', 'examplecsv', get_string('examplecsv', 'tool_resetpasswords'), $link);
        $mform->addHelpButton('examplecsv', 'examplecsv', 'tool_resetpasswords');

        $mform->addElement('filepicker', 'userfile', get_string('file'));
        $mform->addRule('userfile', null, 'required');
        $choices = \csv_import_reader::get_delimiter_list();
        $mform->addElement('select', 'delimiter_name', get_string('csvdelimiter', 'tool_resetpasswords'), $choices);

        if (array_key_exists('cfg', $choices)) {
            $mform->setDefault('delimiter_name', 'cfg');
        } else if (get_string('listsep', 'langconfig') == ';') {
            $mform->setDefault('delimiter_name', 'semicolon');
        } else {
            $mform->setDefault('delimiter_name', 'comma');
        }

        $choices = \core_text::get_encodings();
        $mform->addElement('select', 'encoding', get_string('encoding', 'tool_resetpasswords'), $choices);
        $mform->setDefault('encoding', 'UTF-8');

        $this->add_action_buttons(false, get_string('resetpasswords', 'tool_resetpasswords'));
    }
}
