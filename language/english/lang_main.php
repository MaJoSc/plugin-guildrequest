<?PHP
/********************************************\
* Guildrequest Plugin for EQdkp plus         *
* ------------------------------------------ * 
* Project Start: 01/2009                     *
* Author: BadTwin                            *
* Copyright: Andreas (BadTwin) Schrottenbaum *
* Link: http://eqdkp-plus.com                *
* Version: 0.0.1c                            *
\********************************************/

global $eqdkp;
$lang['guildrequest']                     = 'Guild-Requests';
$lang['request'] 							    				= 'Request';
$lang['rq_short_desc']                    = 'Request-Plugin';
$lang['rq_long_desc']                     = 'A request plugin for EQdkp-Plus';

// Userdaten für den Gastuser
$lang['gr_user_aspirant']                 = 'RequestUser';
$lang['gr_user_email']                    = 'Guest-Profile for the Guild-Request Plugin';



// Admin Menu
$lang['rq_manage']												= 'manage';
$lang['rq_view']                          = 'View Request';
$lang['rq_write']                         = 'Write Request';

// Bewerbung erstellen
$lang['gr_write_headline']                = 'Compose Request';
$lang['gr_write_incorrect_mail']          = 'You entered an invalid mail address';
$lang['gr_write_allfields']               = 'All fields have to be filled out!';
$lang['gr_write_sendrequest']             = 'send request';
$lang['gr_write_reset']                   = 'reset';
$lang['gr_mailsent']                      = 'Please confirm your Request by clicking the link in the mail.';
$lang['gr_mail_topic']                    = 'Confirm your Request at '.$eqdkp->config['guildtag'];
$lang['gr_mail_text1']                    = 'Please confirm your Request by clicking following link:';
$lang['gr_mail_text2']                    = 'Have a nice day. The Guildleadership.';
$lang['gr_username_f']                    = 'username:';
$lang['gr_email_f']                       = 'e-mail:';
$lang['gr_password_f']                    = 'password:';
$lang['gr_text_f']                        = 'text:';
$lang['rq_settings']                      = 'Settings';
$lang['gr_user_double']                   = 'An user with the same name has already sent a request. Please choose another name.';
$lang['gr_welcome_text']                  = 'Thank you for you interest on '.$eqdkp->config['guildtag'].'. Please write your request below:';

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
$lang['gr_goback']                        = 'back';
$lang['gr_poll_headline']                 = 'Should the candidate be invited to the guild?';
$lang['gr_poll_yes']                      = 'yes';
$lang['gr_poll_no']                       = 'no';
  // Admin-Ansicht
  $lang['gr_poll_ad_opened']              = 'opened';
  $lang['gr_poll_ad_closed']              = 'closed';
  $lang['gr_poll_ad_save']                = 'saved';
  $lang['gr_ad_adminonly']                = 'closed requests - only admins can see:';
  
// Administrationsbereich
$lang['gr_ad_config_headline']            = 'Requests - Settings';
$lang['gr_ad_poll_activated']             = 'Polls activated';
$lang['gr_ad_headline_f']                 = 'welcome text:';
$lang['gr_ad_mail1_f']                    = 'first part of the registration mail:';
$lang['gr_ad_mail2_f']                    = 'second part of the registration mail:';
$lang['gr_ad_update_succ']                = 'the settings have been saved!';
?>
