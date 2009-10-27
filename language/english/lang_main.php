<?PHP
/********************************************\
* Guildrequest Plugin for EQdkp plus         *
* ------------------------------------------ *
* Project Start: 01/2009                     *
* Author: BadTwin                            *
* Copyright: Andreas (BadTwin) Schrottenbaum *
* Link: http://eqdkp-plus.com                *
* Version: 0.0.2                             *
\********************************************/

global $eqdkp;
$lang['guildrequest']                     = 'Guild-Requests';
$lang['request'] 							    				= 'Request';
$lang['gr_short_desc']                    = 'Recruitement-Plugin';
$lang['gr_long_desc']                     = 'A plugin for Recruiting';

// Userdaten für den Gastuser
$lang['gr_user_aspirant']                 = 'RequestUser';
$lang['gr_user_email']                    = 'Guest-Profile for the Guild-Request Plugin';

//Editor
$lang['editor_language']	= 'en';

// Admin Menu
$lang['gr_manage']												= 'Manage';
$lang['gr_view']                          = 'View Request';
$lang['gr_write']                         = 'Write Request';

// Bewerbung erstellen
$lang['gr_write_headline']                = 'Compose Request';
$lang['gr_write_incorrect_mail']          = 'You entered an invalid mail address';
$lang['gr_write_allfields']               = 'All fields have to be filled out!';
$lang['gr_write_sendrequest']             = 'Send request';
$lang['gr_write_reset']                   = 'Reset';
$lang['gr_write_error']                   = 'Error';
$lang['gl_write_succ']                    = 'Mail sent';
$lang['gr_mailsent']                      = 'Please confirm your Request by clicking the link in the mail.';
$lang['gr_mail_topic']                    = 'Confirm your Request at '.sanitize($eqdkp->config['guildtag']);
$lang['gr_mail_text1']                    = 'Please confirm your Request by clicking following link:';
$lang['gr_mail_text2']                    = 'Have a nice day. The Guildleadership.';
$lang['gr_username_f']                    = 'Username:';
$lang['gr_email_f']                       = 'E-mail:';
$lang['gr_password_f']                    = 'Password:';
$lang['gr_text_f']                        = 'Text:';
$lang['gr_settings']                      = 'Settings';
$lang['gr_user_double']                   = 'An user with the same name has already sent a request. Please choose another name.';
$lang['gr_welcome_text']                  = 'Thank you for you interest on '.sanitize($eqdkp->config['guildtag']).'. Please write your request below:';

// Bestätigung
$lang['gr_activate_succ']                 = 'Your request has been sent!';

// Login
$lang['gr_login_headline']                = 'Request - Login';
$lang['gr_login_succ']                    = 'Login successfull';
$lang['gr_login_not_activated']           = 'You did not confirm the registration mail.';
$lang['gr_login_wrong']                   = 'Wrong Username or Password.';
$lang['gr_login_empty']                   = 'Please fill out all fields!';
$lang['gr_login_submit']                  = 'Login';
$lang['gr_login_reset']                   = 'Reset';
$lang['gr_showrequest_headline']          = 'Request: ';
$lang['gr_answer_f']                      = 'Answer:';
$lang['gr_closed_headline']               = 'The request has been closed.';

// Member-Ansicht
$lang['gr_vr_not_voted']                  = 'You have not voted yet!';
$lang['gr_vr_voted']                      = 'Your vote has been accepted!';
$lang['gr_goback']                        = 'Back';
$lang['gr_poll_headline']                 = 'Should the candidate be invited to the guild?';
$lang['gr_poll_yes']                      = 'Yes';
$lang['gr_poll_no']                       = 'No';
  // Admin-Ansicht
  $lang['gr_poll_ad_opened']              = 'Opened';
  $lang['gr_poll_ad_closed']              = 'Closed';
  $lang['gr_poll_ad_save']                = 'Save';
  $lang['gr_ad_adminonly']                = 'closed requests - only admins can see:';
  $lang['gr_ad_delete']                   = 'Delete';
  $lang['gr_ad_activate']                 = 'Activate';
  $lang['gr_not_activated']               = 'Not activated requests:';
  $lang['gr_no_requests']                 = 'There are no existing requests.';
  // Info-Boxen
  $lang['gr_vr_ad_opened_f']              = 'Opened';
  $lang['gr_vr_ad_opened']                = 'The request has been opened';
  $lang['gr_vr_ad_closed_f']              = 'Closed';
  $lang['gr_vr_ad_closed']                = 'The request has been closed';
  $lang['gr_vr_ad_activated_f']           = 'Activated';
  $lang['gr_vr_ad_activated']             = 'The request has been activated';
  $lang['gr_vr_ad_deleted_f']             = 'Deleted';
  $lang['gr_vr_ad_deleted']               = 'The request has been deleted';


// Administrationsbereich
$lang['gr_ad_config_headline']            = 'Requests - Settings';
$lang['gr_ad_poll_activated']             = 'Polls activated';
$lang['gr_ad_headline_f']                 = 'Welcome text:';
$lang['gr_ad_mail1_f']                    = 'First part of the registration mail:';
$lang['gr_ad_mail2_f']                    = 'Second part of the registration mail:';
$lang['gr_ad_update_succ']                = 'The settings have been saved!';
$lang['gr_ad_update_succ_hl']             = 'Success!';

// Portal Module
$lang['gr_pm_one_not_voted']              = 'There is a request waiting for your Poll.';
$lang['gr_pm_not_voted_1']                = 'There are ';
$lang['gr_pm_not_voted_2']                = ' requests waiting for your poll!';

$lang['gr_pu_new_query']                  = 'New Request: ';




$lang['gr_form_manage']                   = 'Edit form';
$lang['gr_ad_form_singletext']            = 'Singletext';
$lang['gr_ad_form_textfield']             = 'Textfield';
$lang['gr_ad_form_dropdown']              = 'Dropdown';
$lang['gr_ad_fieldname_f']                = 'Field Name';
$lang['gr_ad_fieldtype_f']                = 'Field Type';
$lang['gr_ad_requiredfield_f']            = 'Required';
$lang['gr_ad_editdropdown']               = 'Edit options';
$lang['gr_ad_editoptions']                = 'Edit options';
$lang['gr_ad_succ_head']                  = 'Changes Saved';
$lang['gr_ad_succ_text']                  = 'The Changes have been saved successfully';
$lang['gr_ad_err_dropdown']               = 'You didn\'t choose a fieldname';
$lang['gr_ad_succ_del']                   = 'Field deleted successfully';
$lang['gr_ad_sort_f']                     = 'Sorting';
$lang['gr_ad_preview_f']                  = 'Preview';
$lang['gr_vr_view']                       = 'View application';
$lang['gr_comment']                       = 'Write comments';
$lang['gr_ad_closingmail']                = 'Inform applicant';
$lang['gr_ad_closingtext']                = 'Your application has been closed. Our Users voted as follows:';
$lang['gr_ad_replyadress']                = 'This is an autmatically generated E-Mail. Please send your reply to: ';
$lang['gr_sendermail']                    = 'From:';
$lang['gr_ad_popup_activated']		  			= 'Show popup when inactive applications exist? (only neccessary, if the sending of mails doesn\'t work)';
$lang['gr_ad_notactivated_popup']					= 'Application not activated!';
$lang['gr_poll_voted_yet']                = 'Intermediate result ';
$lang['gr_vote']                          = 'Vote';
$lang['gr_ad_form_headline']              = 'Headline';
$lang['gr_ad_form_spaceline']             = 'Empty line';
$lang['gr_ad_sm_submit']									= 'Send';

$lang['gr_mailnotsent']										= 'Error while sending activation mail. Please contact the administrator.';
$lang['gr_write_error']										= 'Error!';
$lang['gr_closingmail_hl']								= 'Application closed';
$lang['gr_closingmail_submit']						= 'Send';
?>