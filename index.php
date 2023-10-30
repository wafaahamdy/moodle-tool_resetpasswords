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

require('../../../config.php');    /// required for all Moodle functionalities
require_once($CFG->libdir.'/csvlib.class.php');   /// required to handle CSV functions
require_once($CFG->libdir."/moodlelib.php");
 


// to load upload form
require_once($CFG->dirroot.'/'.$CFG->admin.'/tool/resetpasswords/form.php');  

// make sure user is logined and has permission to change
require_login();
$systemcontext   = context_system::instance(); 
// Check access control.
if ($USER->id) {
    echo ($USER->id) ;
    //  require_login() MUST NOT be used here, it would result in infinite loop!
    if (!has_capability('tool/resetpasswords:bulkresetpassword', $systemcontext)) {
        throw new \moodle_exception('accessdenied', 'admin');
      }

}  else { throw new \moodle_exception('usernotavailable') ;}

/// start building page content

///   Page Header
$PAGE->set_title(get_string('pluginname', 'tool_resetpasswords'));
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'tool_resetpasswords'));

// set the url of the page for continue button
$returnurl = new moodle_url('/admin/tool/resetpasswords/index.php');
// check if the user already sent file or not
$iid         = optional_param('iid', '', PARAM_INT);



if (empty($iid)) { /// this is the first load to page or list is not handled yet 
    
// intiate form object
 $mform1 = new upload_list_form();  
 
 if ($formdata = $mform1->get_data()) {   
        $iid = csv_import_reader::get_new_iid('uploaduser');
        $cir = new csv_import_reader($iid, 'uploaduser');
        $content = $mform1->get_file_content('userfile');

//  bool false if error, count of data lines if ok; use get_error() to get error string
        $readcount = $cir->load_csv_content($content, $formdata->encoding, $formdata->delimiter_name);
        $csvloaderror = $cir->get_error();
        unset($content);
        // throw error if csv file is empty
        if (!is_null($csvloaderror)) {
            throw new \moodle_exception('csvloaderror', '', $returnurl, $csvloaderror);
        }
       

    } else {
 // if no data is sent, just display the form
        $mform1->display();
        echo $OUTPUT->footer();
        die;
    }
} else {  
   $cir = new csv_import_reader($iid, 'uploaduser');
}


/// Start working on Reset password process


// 1) Test if columns are ok.
 
$filecolumns =$cir->get_columns();

    if (empty($filecolumns)) {
        $cir->close();
        $cir->cleanup();
        throw new \moodle_exception('cannotreadtmpfile', 'error', $returnurl);
    }
    if (count($filecolumns) > 1 || !(in_array('username', $filecolumns)) )  {
        $cir->close();
        $cir->cleanup();
        
     throw new \moodle_exception('csvloaderror', 'error', $returnurl, 'Only one column with header username is allowed');
    }


$dd = $cir-> init();

echo '<table    class="generaltable boxaligncenter flexible-wrap" summary="'.get_string('uploadusersresult', 'tool_uploaduser').'">';
        echo '<tr class="heading r0">';
        echo '<th class="header" scope="col">'.$filecolumns[0].'</th>';
        echo '<th class="header" scope="col">'. get_string('action', 'tool_resetpasswords') .'   </th>';
        echo '</tr>';
 

global $DB ;
$generated = 0 ;   // counter for number of processed data
$escaped = 0;   // counter for number of escaped data


/// loop csv filr rows
for ($i=0; $i<$readcount-1; $i++){
   $usernames = $cir-> next(); 
     echo '<tr class="r0">';
     echo '<td scope="col">'. $usernames[0] . '</td>';
      $cuser =    get_complete_user_data('username', $usernames[0]);
         
      if($cuser){  // the user found

        set_user_preference('bulk_resetpassword',1, $cuser);
            echo '<td scope="col"> '. get_string('password_cron', 'tool_resetpasswords') .'   </td>';  
          $generated ++;

   }  else {  // user not found
    echo '<td scope="col">'. get_string('usernotfound', 'tool_resetpasswords') .' </td>'; 
    $escaped ++;
   }   
echo '</tr>' ;
}
echo "</table>" ;
echo "<div>
". get_string('reseted_users', 'tool_resetpasswords') .": $generated <br/>
". get_string('escaped_users', 'tool_resetpasswords') .": $escaped <br/>
". get_string('total', 'tool_resetpasswords') ." : ".($generated+$escaped)."
</div>";




 

 
 
echo $OUTPUT->continue_button($returnurl);
 echo $OUTPUT->footer();
