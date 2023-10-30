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
 * Plugin strings are defined here.
 *
 * @package     tool_resetpasswords
 * @category    string
 * @copyright   2023 Wafaa Hamdy <eng.wafaa.hamdy@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Bulk rest password';
$string['taskname'] = 'Bulk rest password';
$string['action'] = 'Action';

// form Strings
$string['uploadusers'] = 'Bulk Reset Password';
$string['resetpasswords'] = 'Reset Passwords';
$string['resetpasswords:bulkresetpassword'] = "Bulk reset password by CSV file upload" ;
$string['examplecsv'] = "Example CSV" ;
$string['examplecsv_help'] = "Upload CSV file with only on column for <b>username</b>, as found in this example file" ;
$string['csvdelimiter'] = "CSV separator" ;
$string['encoding'] = "Encoding" ;

$string['password_cron'] =  "Password is generated in cron " ;
$string['usernotfound'] = " User not found";
$string['reseted_users'] =  "Password reseted users" ;
$string['escaped_users'] = "Escaped users" ;
$string['total'] = "Total";


/// Email Strings
$string['emailsubject'] = 'User account password reset';
$string['emailsender'] = '{$a->siteshortname} Site Admin' ;
$string['emailbodyhtml'] ='<div> Hi {$a->userfullname} , <br/>
Your user account password at <b> {$a->sitename} </b> has been reset by admin.
<br/> Your current login information is now:
<br/><br/>
Username: {$a->username} <br/>
Password: {$a->password} <br/><br/>
URL: {$a->URL}
</div>' ;

