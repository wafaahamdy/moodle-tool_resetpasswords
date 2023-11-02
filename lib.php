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
 
 defined('MOODLE_INTERNAL') || die();


function reset_password_sendmail($cuser){
  global $SITE , $CFG , $DB;
 
  $emailsubject = get_string('emailsubject','tool_resetpasswords');
  $emailsender = get_string('emailsender','tool_resetpasswords',['siteshortname'=>$SITE->shortname]); 
  $password =generate_password(10) ; 
  $cuser->password = $password ;
  user_update_user($cuser , true);

  $mailbody =  get_string('emailbodyhtml','tool_resetpasswords',[
    'userfullname' => $cuser->firstname . ' ' . $cuser->lastname ,
    'username'=> $cuser->username,
    'password' => $password,
    'URL' => $CFG->wwwroot . '/login/index.php',
    'sitename' => $SITE->fullname
    ]); 
 
  email_to_user($cuser, $emailsender, $emailsubject, $mailbody,false);
  set_user_preference('auth_forcepasswordchange',1, $cuser);
  unset_user_preference('bulk_resetpassword', $cuser);
 
}

 
