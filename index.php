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
 * Bulk user registration script from a comma separated file
 *
 * @package     tool_resetpasswords
 * @copyright   2023 Wafaa Hamdy <eng.wafaa.hamdy@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../../config.php');
require_once($CFG->libdir.'/csvlib.class.php');
require_once($CFG->libdir."/moodlelib.php");

require_login();
$systemcontext = context_system::instance();

if ($USER->id) {
    if (!has_capability('tool/resetpasswords:bulkresetpassword', $systemcontext)) {
        throw new \moodle_exception('accessdenied', 'admin');
    }
} else {
    new \moodle_exception('usernotavailable');
}


$PAGE->set_title(get_string('pluginname', 'tool_resetpasswords'));
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'tool_resetpasswords'));


$returnurl = new moodle_url('/admin/tool/resetpasswords/index.php');
$iid = optional_param('iid', '', PARAM_INT);

if (empty($iid)) {

    $mform1 = new \tool_resetpasswords\form\uploadlistform();
    if ($formdata = $mform1->get_data()) {
        $iid = csv_import_reader::get_new_iid('uploaduser');
        $cir = new csv_import_reader($iid, 'uploaduser');
        $content = $mform1->get_file_content('userfile');
        $readcount = $cir->load_csv_content($content, $formdata->encoding, $formdata->delimiter_name);
        $csvloaderror = $cir->get_error();
        unset($content);

        if (!is_null($csvloaderror)) {
            throw new \moodle_exception('csvloaderror', '', $returnurl, $csvloaderror);
        }
    } else {
        $mform1->display();
        echo $OUTPUT->footer();
        die;
    }
} else {
    $cir = new csv_import_reader($iid, 'uploaduser');
}

$filecolumns = $cir->get_columns();
if (empty($filecolumns)) {
    $cir->close();
    $cir->cleanup();
    throw new \moodle_exception('cannotreadtmpfile', 'error', $returnurl);
}
if (count($filecolumns) > 1 || !(in_array('username', $filecolumns))) {
    $cir->close();
    $cir->cleanup();
    throw new \moodle_exception('csvloaderror', 'error', $returnurl, 'Only one column with header username is allowed');
}

$dd = $cir->init();

echo '<table class="generaltable boxaligncenter flexible-wrap" summary="'.get_string('uploadusersresult', 'tool_uploaduser').'">';
echo '<tr class="heading r0">';
echo '<th class="header" scope="col">'.$filecolumns[0].'</th>';
echo '<th class="header" scope="col">'. get_string('action', 'tool_resetpasswords') .'   </th>';
echo '</tr>';

$generated = 0;
$escaped = 0;

for ($i = 0; $i < $readcount - 1; $i++) {
    $usernames = $cir->next();
    echo '<tr class="r0">';
    echo '<td scope="col">'. $usernames[0] . '</td>';
    $cuser = get_complete_user_data('username', $usernames[0]);

    if ($cuser) {
        set_user_preference('bulk_resetpassword', 1, $cuser);
        echo '<td scope="col"> '. get_string('password_cron', 'tool_resetpasswords') .'   </td>';
        $generated ++;
    } else {
        echo '<td scope="col">'. get_string('usernotfound', 'tool_resetpasswords') .' </td>';
        $escaped ++;
    }
    echo '</tr>';
}

echo "</table>";
echo "<div> ". get_string('reseted_users', 'tool_resetpasswords') .": $generated <br/>"
     . get_string('escaped_users', 'tool_resetpasswords') .": $escaped <br/>"
     . get_string('total', 'tool_resetpasswords') ." : ".($generated + $escaped)."</div>";

echo $OUTPUT->continue_button($returnurl);
echo $OUTPUT->footer();
