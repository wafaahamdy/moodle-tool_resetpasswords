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

namespace tool_resetpasswords;

/**
 * Class to manage change and email process
 */
class rest_sendmail {
    /** @var stdClass the user object that needs password chanve */
    public $cuser = null;
    /** @var string   */
    public $emailsubject;
    /** @var string   */
    private $emailsender;
    /** @var string   */
    private $password;

    /**
     * Constructor for the rest_sendmail class
     *
     * @param stdClass $cuser
     */
    public function __construct($cuser) {
        $this->cuser = $cuser;
        $this->emailsubject = get_string('emailsubject', 'tool_resetpasswords');
        $this->emailsender = get_string('emailsender', 'tool_resetpasswords', ['siteshortname' => $SITE->shortname]);
    }
    /**
     * change user password / send email to user / force password change
     */
    public function performreset() {
        global $SITE , $CFG , $DB;
        $this->password = generate_password(10);
        $this->cuser->password = $this->password;
        user_update_user($this->cuser , true);

        $mailbody = get_string('emailbodyhtml', 'tool_resetpasswords', [
        'userfullname' => $this->cuser->firstname . ' ' . $this->cuser->lastname,
        'username' => $this->cuser->username,
        'password' => $this->password,
        'URL' => $CFG->wwwroot . '/login/index.php',
        'sitename' => $SITE->fullname,
        ]);

        email_to_user($this->cuser, $this->emailsender, $this->emailsubject, $mailbody, false);
        set_user_preference('auth_forcepasswordchange', 1, $this->cuser);
        unset_user_preference('bulk_resetpassword', $this->cuser);
    }
}


