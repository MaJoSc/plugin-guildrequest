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
$lang['guildrequest']                     = '±æµå-¿äÃ»';
$lang['request'] 							    				= '¿äÃ»';
$lang['gr_short_desc']                    = '°ø°Ý´ë Ãæ¿ø-ÇÃ·¯±×ÀÎ';
$lang['gr_long_desc']                     = '°ø°Ý´ë Ãæ¿øÀ» À§ÇÑ ÇÃ·¯±×ÀÎ ÀÔ´Ï´Ù.';

// Userdaten für den Gastuser
$lang['gr_user_aspirant']                 = '»ç¿ëÀÚ ¿äÃ»';
$lang['gr_user_email']                    = '±æµå-¿äÃ» ÇÃ·¯±×ÀÎ ¼Õ´Ô¿ë-ÇÁ·ÎÆÄÀÏ';

//Editor
$lang['editor_language']	= 'en';

// Admin Menu
$lang['gr_manage']												= '°ü¸®';
$lang['gr_view']                          = '¿äÃ» º¸±â';
$lang['gr_write']                         = '¿äÃ» ¾²±â';

// Bewerbung erstellen
$lang['gr_write_headline']                = '¿äÃ» ¾²±â';
$lang['gr_write_incorrect_mail']          = 'Àß¸øµÈ ¸ÞÀÏ ÁÖ¼Ò¸¦ ÀÔ·ÂÇÏ¿´½À´Ï´Ù.';
$lang['gr_write_allfields']               = '¸ðµç °ø°£ÀÌ Ã¤¿öÁ®¾ß ÇÕ´Ï´Ù!';
$lang['gr_write_sendrequest']             = '¿äÃ» º¸³»±â';
$lang['gr_write_reset']                   = 'ÃÊ±âÈ­';
$lang['gr_write_error']                   = '¿À·ù';
$lang['gl_write_succ']                    = '¸ÞÀÏ Àü¼ÛµÊ';
$lang['gr_mailsent']                      = '¸ÞÀÏÀÇ ¸µÅ©¸¦ ÅëÇØ ¿äÃ»À» È®ÀÎÇÏ¼¼¿ä.';
$lang['gr_mail_topic']                    = '¿äÃ»À» È®ÀÎÇÏ¼¼¿ä  '.preg_replace("'", "\'", $eqdkp->config['guildtag']);
$lang['gr_mail_text1']                    = '´ÙÀ½ ¸µÅ©¸¦ Å¬¸¯ÇØ¼­ ¿äÃ»À» È®ÀÎÇÏ¼¼¿ä :';
$lang['gr_mail_text2']                    = 'ÁÁÀº ÇÏ·çµÇ¼¼¿ä.';
$lang['gr_username_f']                    = '»ç¿ëÀÚ ÀÌ¸§:';
$lang['gr_email_f']                       = 'ÀÌ¸ÞÀÏ:';
$lang['gr_password_f']                    = 'ºñ¹Ð¹øÈ£:';
$lang['gr_text_f']                        = 'ÅØ½ºÆ®:';
$lang['gr_settings']                      = '¼³Á¤';
$lang['gr_user_double']                   = '°°Àº ÀÌ¸§ÀÇ »ç¿ëÀÚ°¡ ÀÌ¹Ì ¿äÃ»Çß½À´Ï´Ù. ´Ù¸¥ ÀÌ¸§À» »ç¿ëÇÏ¼¼¿ä.';
$lang['gr_welcome_text']                  = ' '.preg_replace("'", "\'", $eqdkp->config['guildtag']).'. ¿¡ °ü½ÉÀ» °¡Á®ÁÖ¼Å¼­ °¨»çÇÕ´Ï´Ù. ¾Æ·¡¿¡ ¿äÃ»»çÇ×À» Àû¾îÁÖ½Ã±â ¹Ù¶ø´Ï´Ù:';

// Bestätigung
$lang['gr_activate_succ']                 = '¿äÃ» º¸³¿!';

// Login
$lang['gr_login_headline']                = '¿äÃ» - ·Î±×ÀÎ';
$lang['gr_login_succ']                    = '·Î±×ÀÎ ¼º°ø';
$lang['gr_login_not_activated']           = 'µî·Ï ¸ÞÀÏÀ» È®ÀÎÇÏÁö ¾ÊÀ¸¼Ì½À´Ï´Ù.';
$lang['gr_login_wrong']                   = '¸° »ç¿ëÀÚ ÀÌ¸§ ¶Ç´Â ÆÐ½º¿öµåÀÔ´Ï´Ù.';
$lang['gr_login_empty']                   = '¸ðµç ºóÄ­À» Ã¤¿öÁÖ¼¼¿ä!';
$lang['gr_login_submit']                  = '·Î±×ÀÎ';
$lang['gr_login_reset']                   = 'ÃÊ±âÈ­';
$lang['gr_showrequest_headline']          = '¿äÃ»: ';
$lang['gr_answer_f']                      = '´äº¯:';
$lang['gr_closed_headline']               = '¿äÃ» °ÇÀÌ ¸¶¹«¸® µÇ¾ú½À´Ï´Ù.';

// Member-Ansicht
$lang['gr_vr_not_voted']                  = '¾ÆÁ÷ ÅõÇ¥ÇÏÁö ¾ÊÀ¸¼Ì½À´Ï´Ù!';
$lang['gr_vr_voted']                      = 'ÅõÇ¥°¡ ¼º°øÀûÀ¸·Î ÀÌ·ç¾îÁ³½À´Ï´Ù!';
$lang['gr_goback']                        = 'µ¹¾Æ°¡±â';
$lang['gr_poll_headline']                 = 'Áö¿øÀÚ¸¦ °ø°Ý´ë¿øÀ¸·Î ÃÊ´ëÇÒ±î¿ä?';
$lang['gr_poll_yes']                      = '¿¹';
$lang['gr_poll_no']                       = '¾Æ´Ï¿À';
  // Admin-Ansicht
  $lang['gr_poll_ad_opened']              = '¿­¸²';
  $lang['gr_poll_ad_closed']              = '´ÝÈû';
  $lang['gr_poll_ad_save']                = 'ÀúÀåµÊ';
  $lang['gr_ad_adminonly']                = 'Â÷´ÜµÈ ¿äÃ» - °ü¸®ÀÚ¸¸ º¼ ¼ö ÀÖ½À´Ï´Ù.:';
  $lang['gr_ad_delete']                   = '»èÁ¦';
  $lang['gr_ad_activate']                 = 'È°¼ºÈ­';
  $lang['gr_not_activated']               = 'È°¼ºÈ­µÇÁö ¾ÊÀº ¿äÃ»:';
  $lang['gr_no_requests']                 = '¿äÃ»ÀÌ ¾ø½À´Ï´Ù.';
  // Info-Boxen
  $lang['gr_vr_ad_opened_f']              = '¿­¸²';
  $lang['gr_vr_ad_opened']                = '¿äÃ»ÀÌ ¿­·È½À´Ï´Ù.';
  $lang['gr_vr_ad_closed_f']              = '´ÝÈû';
  $lang['gr_vr_ad_closed']                = '¿äÃ»ÀÌ Â÷´ÜµÇ¾ú½À´Ï´Ù.';
  $lang['gr_vr_ad_activated_f']           = 'È°¼ºÈ­µÊ';
  $lang['gr_vr_ad_activated']             = '¿äÃ»ÀÌ È°¼ºÈ­µÇ¾ú½À´Ï´Ù.';
  $lang['gr_vr_ad_deleted_f']             = '»èÁ¦µÊ';
  $lang['gr_vr_ad_deleted']               = '¿äÃ»ÀÌ »èÁ¦µÇ¾ú½À´Ï´Ù.';

  
// Administrationsbereich
$lang['gr_ad_config_headline']            = '¿äÃ» - ¼³Á¤';
$lang['gr_ad_poll_activated']             = 'ÅõÇ¥°¡ È°¼ºÈ­ µÇ¾ú½À´Ï´Ù.';
$lang['gr_ad_headline_f']                 = 'È¯¿µ ¹®±¸:';
$lang['gr_ad_mail1_f']                    = 'µî·Ï¸ÞÀÏÀÇ Ã¹¹øÂ° ºÎºÐ:';
$lang['gr_ad_mail2_f']                    = 'µî·Ï¸ÞÀÏÀÇ µÎ¹øÂ° ºÎºÐ:';
$lang['gr_ad_update_succ']                = '¼³Á¤ÀÌ ÀúÀåµÇ¾ú½À´Ï´Ù!';
$lang['gr_ad_update_succ_hl']             = '¼º°ø!';

// Portal Module
$lang['gr_pm_one_not_voted']              = '´ë±â ÅõÇ¥°¡ ÀÖ½À´Ï´Ù.';
$lang['gr_pm_not_voted_1']                = '';
$lang['gr_pm_not_voted_2']                = ' °³ÀÇ ´ë±â ÅõÇ¥°¡ ÀÖ½À´Ï´Ù!!';

$lang['gr_pu_new_query']                  = '»õ ¿äÃ»: ';




$lang['gr_form_manage']                   = 'Æû ÆíÁýÇÏ±â';
$lang['gr_ad_form_singletext']            = '´Ü¹®';
$lang['gr_ad_form_textfield']             = 'ÅØ½ºÆ®ÇÊµå';
$lang['gr_ad_form_dropdown']              = 'µå¶ø´Ù¿î';
$lang['gr_ad_fieldname_f']                = 'ÇÊµåÀÌ¸§';
$lang['gr_ad_fieldtype_f']                = 'ÇÊµåÅ¸ÀÔ';
$lang['gr_ad_requiredfield_f']            = '¿ä±¸µÊ';
$lang['gr_ad_editdropdown']               = 'ÆíÁý ¿É¼Ç';
$lang['gr_ad_editoptions']                = 'ÆíÁý ¿É¼Ç';
$lang['gr_ad_succ_head']                  = 'º¯°æ ÀúÀåµÊ';
$lang['gr_ad_succ_text']                  = 'º¯°æ»çÇ×ÀÌ ¼º°øÀûÀ¸·Î ÀúÀåµÇ¾ú½À´Ï´Ù.';
$lang['gr_ad_err_dropdown']               = 'ÇÊµåÀÌ¸§À» ¼±ÅÃÇÏÁö ¾ÊÀ¸¼Ì½À´Ï´Ù.';
$lang['gr_ad_succ_del']                   = 'ÇÊµå°¡ ¼º°øÀûÀ¸·Î »èÁ¦µÇ¾ú½À´Ï´Ù.';
$lang['gr_ad_sort_f']                     = 'Á¤·Ä';
$lang['gr_ad_preview_f']                  = '¹Ì¸®º¸±â';
$lang['gr_vr_view']                       = 'Áö¿ø¼­ º¸±â';
$lang['gr_comment']                       = 'ÄÚ¸àÆ® ¾²±â';
$lang['gr_ad_closingmail']                = 'Áö¿øÀÚ¿¡°Ô ¾Ë¸®±â';
$lang['gr_ad_closingtext']                = 'Áö¿ø °á°ú°¡ ³ª¿Ô½À´Ï´Ù. °á°ú´Â ´ÙÀ½°ú °°½À´Ï´Ù:';
$lang['gr_ad_replyadress']                = 'ÀÌ ¸ÞÀÏÀº ÀÚµ¿À¸·Î »ý¼ºµË´Ï´Ù. È¸½ÅÀº ´ÙÀ½ ÁÖ¼Ò·Î ÇØÁÖ¼¼¿ä: ';
$lang['gr_sendermail']                    = 'º¸³½ »ç¶÷:';
$lang['gr_ad_popup_activated']		  			= 'È°¼ºÈ­ µÇÁö ¾ÊÀº Áö¿ø¼­°¡ ÀÖÀ»¶§ ÆË¾÷À» º¸½Ã°Ú½À´Ï±î? (¸ÞÀÏ º¸³»±â°¡ µÇÁö ¾ÊÀ»¶§¸¸ ÇÊ¿äÇÕ´Ï´Ù)';
$lang['gr_ad_notactivated_popup']					= 'Áö¿ø¼­°¡ È°¼ºÈ­µÇÁö ¾Ê¾Ò½À´Ï´Ù.';
$lang['gr_poll_voted_yet']                = 'Áß°£ °á°ú';
$lang['gr_vote']                          = 'ÅõÇ¥';
$lang['gr_ad_form_headline']              = 'Á¦¸ñ';
$lang['gr_ad_form_spaceline']             = 'ºó ¶óÀÎ';
?>
