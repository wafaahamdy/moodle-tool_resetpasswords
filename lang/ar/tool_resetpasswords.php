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

 defined('MOODLE_INTERNAL') || die();

 $string['pluginname'] = 'اعادة ضبط كلمة المرور لمجموعة';
 $string['taskname'] = 'اعادة ضبط كلمة المرور لمجموعة';
 $string['action'] = 'ما تم عمله';
 // Form Strings.
 $string['uploadusers'] = 'رفع ملف المستخدمين';
 $string['resetpasswords'] = 'اعادة ضبط كلمة المرور';
 $string['resetpasswords:bulkresetpassword'] = "Bulk reset password by CSV file upload";
 $string['examplecsv'] = "ملف كمثال";
 $string['examplecsv_help'] = "قم برفع ملف CSV  يحتوي عمود واحد ل  <b>username</b>, كما هو موضح في ملف المثال";
 $string['csvdelimiter'] = "CSV فاصل";
 $string['encoding'] = "التشفير";

 $string['password_cron'] = "سيتم ارسال كلمة المرور في ال cron";
 $string['usernotfound'] = "لم يتم العثور على هذا المستخدم";
 $string['reseted_users'] = "مستخدمين تم اعادة ضبط كلمة المرور لهم";
 $string['escaped_users'] = " مستخدمين لم تكمل عمليتهم";
 $string['total'] = "العدد الكلي";

 // Email Strings.
 $string['emailsubject'] = 'اعادة ضبط كلمة مرورك';
 $string['emailsender'] = '{$a->siteshortname} Site Admin';
 $string['emailbodyhtml'] = '<div dir = "rtl" style:"text-align:right"> أهلا {$a->userfullname} , <br/>
 تم تغيير كلمة المرمر الخاصة بك في  <b> {$a->sitename} </b> بواسطة الموقع.
 <br/> معلومات دخولك للموقع كالاتي:
 <br/><br/>
اسم المستخدم: {$a->username} <br/>
 كلمة المرور: {$a->password} <br/><br/>
 URL: {$a->URL}
 </div>';
