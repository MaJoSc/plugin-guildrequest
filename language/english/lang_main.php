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
$lang['gr_manage']												= 'manage';
$lang['gr_view']                          = 'View Request';
$lang['gr_write']                         = 'Write Request';

// Bewerbung erstellen
$lang['gr_write_headline']                = 'Compose Request';
$lang['gr_write_incorrect_mail']          = 'You entered an invalid mail address';
$lang['gr_write_allfields']               = 'All fields have to be filled out!';
$lang['gr_write_sendrequest']             = 'send request';
$lang['gr_write_reset']                   = 'reset';
$lang['gr_write_error']                   = 'Error';
$lang['gl_write_succ']                    = 'Mail sent';
$lang['gr_mailsent']                      = 'Please confirm your Request by clicking the link in the mail.';
$lang['gr_mail_topic']                    = 'Confirm your Request at '.ereg_replace("'", "\'", $eqdkp->config['guildtag']);
$lang['gr_mail_text1']                    = 'Please confirm your Request by clicking following link:';
$lang['gr_mail_text2']                    = 'Have a nice day. The Guildleadership.';
$lang['gr_username_f']                    = 'username:';
$lang['gr_email_f']                       = 'e-mail:';
$lang['gr_password_f']                    = 'password:';
$lang['gr_text_f']                        = 'text:';
$lang['gr_settings']                      = 'Settings';
$lang['gr_user_double']                   = 'An user with the same name has already sent a request. Please choose another name.';
$lang['gr_welcome_text']                  = 'Thank you for you interest on '.ereg_replace("'", "\'", $eqdkp->config['guildtag']).'. Please write your request below:';

// Bestätigung
$lang['gr_activate_succ']                 = 'Your request has been sent!';

// Login
$lang['gr_login_headline']                = 'Request - Login';
$lang['gr_login_succ']                    = 'login successfull';
$lang['gr_login_not_activated']           = 'You did not confirm the registration mail.';
$lang['gr_login_wrong']                   = 'Wrong Username or Password.';
$lang['gr_login_empty']                   = 'Please fill out all fields!';
$lang['gr_login_submit']                  = 'login';
$lang['gr_login_reset']                   = 'reset';
$lang['gr_showrequest_headline']          = 'Request: ';
$lang['gr_answer_f']                      = 'Answer:';
$lang['gr_closed_headline']               = 'The request has been closed.';

// Member-Ansicht
$lang['gr_vr_not_voted']                  = 'You have not voted yet!';
$lang['gr_vr_voted']                      = 'Your vote has been accepted!';
$lang['gr_goback']                        = 'back';
$lang['gr_poll_headline']                 = 'Should the candidate be invited to the guild?';
$lang['gr_poll_yes']                      = 'yes';
$lang['gr_poll_no']                       = 'no';
  // Admin-Ansicht
  $lang['gr_poll_ad_opened']              = 'opened';
  $lang['gr_poll_ad_closed']              = 'closed';
  $lang['gr_poll_ad_save']                = 'saved';
  $lang['gr_ad_adminonly']                = 'closed requests - only admins can see:';
  $lang['gr_ad_delete']                   = 'delete';
  $lang['gr_ad_activate']                 = 'activate';
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
$lang['gr_ad_headline_f']                 = 'welcome text:';
$lang['gr_ad_mail1_f']                    = 'first part of the registration mail:';
$lang['gr_ad_mail2_f']                    = 'second part of the registration mail:';
$lang['gr_ad_update_succ']                = 'the settings have been saved!';
$lang['gr_ad_update_succ_hl']             = 'Success!';

// Portal Module
$lang['gr_pm_one_not_voted']              = 'There is a request waiting for your Poll.';
$lang['gr_pm_not_voted_1']                = 'There are ';
$lang['gr_pm_not_voted_2']                = ' requests waiting for your poll!';

$lang['gr_pu_new_query']                  = 'New Request: ';
?>
