# Bulk rest password #

This plugin enables admins (or any one with permission) to bulk reset users password and send password to users by email. Force password change will be set for those users.

The process starts by uploading a CSV file with usernames to mark users who need password reset. A scheduled task is used to perform the process of resetting password and sending mail to users.

### Role and permissions ###
This plugin can be used in system context. 
A permission “tool/resetpasswords:bulkresetpassword” can be granted to any role.
This permission is granted by default to admin & manager roles.

### To access this tool ###
The tool is available under _site administration -> users -> accounts -> Bulk reset password_

### Scheduled task ###
Process scheduled task is _tool_resetpasswords\task\bulkreset_passwords_


## Installing via uploaded ZIP file ##

1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
2. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

## Installing manually ##

The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/admin/tool/resetpasswords

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## License ##

2023 Wafaa Hamdy <eng.wafaa.hamdy@gmail.com>

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <https://www.gnu.org/licenses/>.
