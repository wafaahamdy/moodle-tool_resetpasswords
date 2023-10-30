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
 * Sync bulk reset password task  task
 * * @package     tool_resetpasswords
 * @copyright   2023 Wafaa Hamdy <eng.wafaa.hamdy@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_resetpasswords\task ;

defined('MOODLE_INTERNAL') || die();
 
require_once($CFG->dirroot.'/'.$CFG->admin.'/tool/resetpasswords/lib.php');  

class bulkreset_passwords extends \core\task\scheduled_task {

    /**
     * Name for this task.
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskname', 'tool_resetpasswords');
    }

    /**
     * Run task for Bulk reset password.
     */
    public function execute() {
        global $DB;
          // Generate password and send email for users 
          // check for users that needs password reset 
          if ($DB->count_records('user_preferences', array('name' => 'bulk_resetpassword', 'value' => '1'))) {
            mtrace('Creating passwords for new users...');
            

            $userfieldsapi = \core_user\fields::for_name();
            $usernamefields = $userfieldsapi->get_sql('u', false, '', '', false)->selects;
            $cusers = $DB->get_recordset_sql("SELECT u.id as id, u.email, 
                                                     $usernamefields, u.username
                                                FROM {user} u
                                                JOIN {user_preferences} p ON u.id=p.userid
                                               WHERE p.name='bulk_resetpassword' AND p.value='1' AND
                                                     u.email !='' AND u.suspended = 0 AND
                                                     u.auth != 'nologin' AND u.deleted = 0");

               foreach ($cusers as $cuser) {
                resetPassword_sendmail($cuser);  
      
           }
            $cusers->close();
        }else{
          mtrace('No bulk password reset is needed!');
        }

    
    }

}
