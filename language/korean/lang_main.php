<?php
/*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * EQdkp-Plus uses a PHP-based translate tool named "Entrans".
 * This file was automatically generated from translated strings.
 * -----------------------------------------------------------------------
 * $Id: $
 */

// Do not remove. Security Option!
if(!defined('EQDKP_INC')) {
	header('HTTP/1.0 404 Not Found');
	exit;
}

$lang['<?PHP'] = "<?PHP/********************************************\* Guildrequest Plugin for EQdkp plus ** ------------------------------------------ * * Project Start: 01/2009 ** Author: BadTwin ** Copyright: Andreas (BadTwin) Schrottenbaum ** Link: http://eqdkp-plus.com ** Version: 0.0.2 *\********************************************/global $eqdkp;";
$lang['guildrequest'] = "길드-요청";
$lang['request'] = "요청";
$lang['gr_short_desc'] = "공격대 충원 - 플러그인";
$lang['gr_long_desc'] = "공격대 충원 플러그인";
$lang['gr_user_aspirant'] = "사용자요청";
$lang['gr_user_email'] = "길드-요청 플러그인 손님용-프로파일";
$lang['editor_language'] = "kr";
$lang['gr_manage'] = "관리";
$lang['gr_view'] = "요청보기";
$lang['gr_write'] = "요청쓰기";
$lang['gr_write_headline'] = "요청쓰기";
$lang['gr_write_incorrect_mail'] = "잘못된 메일주소를 입력하셨습니다.";
$lang['gr_write_allfields'] = "모든 빈칸을 채우셔야합니다!";
$lang['gr_write_sendrequest'] = "요청 보내기";
$lang['gr_write_reset'] = "초기화";
$lang['gr_write_error'] = "에러";
$lang['gl_write_succ'] = "메일 보냄";
$lang['gr_mailsent'] = "메일의 링크를 통해 요청을 확인하세요.";
$lang['gr_mail_topic'] = "요청을 확인하세요 ".ereg_replace("'", "\'", $eqdkp->config['guildtag']);
$lang['gr_mail_text1'] = "다음 링크를 클릭해서 요청을 확인하세요.";
$lang['gr_mail_text2'] = "좋은 하루되세요.";
$lang['gr_username_f'] = "사용자 이름";
$lang['gr_email_f'] = "이메일";
$lang['gr_password_f'] = "패스워드";
$lang['gr_text_f'] = "내용";
$lang['gr_settings'] = "설정";
$lang['gr_user_double'] = "같은 이름의 사용자가 이미 요청했습니다. 다른 이름을 사용하세요.";
$lang['gr_welcome_text'] = ''.ereg_replace("'", "\'", $eqdkp->config['guildtag']).'에 관심을 가져주셔서 감사합니다. 아래에 요청사항을 적어주시기 바랍니다:';
$lang['gr_activate_succ'] = "요청 보냄";
$lang['gr_login_headline'] = "로그인 요청";
$lang['gr_login_succ'] = "로그인 성공";
$lang['gr_login_not_activated'] = "등록 메일을 확인하지 않으셨습니다.";
$lang['gr_login_wrong'] = "틀린 사용자 이름 또는 패스워드입니다.";
$lang['gr_login_empty'] = "모든 빈칸을 채워주세요!";
$lang['gr_login_submit'] = "로그인";
$lang['gr_login_reset'] = "초기화";
$lang['gr_showrequest_headline'] = "요청:";
$lang['gr_answer_f'] = "답변:";
$lang['gr_closed_headline'] = "요청 건이 마무리 되었습니다.";
$lang['gr_vr_not_voted'] = "아직 투표하지 않으셨습니다!";
$lang['gr_vr_voted'] = "투표가 성공적으로 이루어졌습니다!";
$lang['gr_goback'] = "돌아가기";
$lang['gr_poll_headline'] = "지원자를 공격대원으로 초대할까요?";
$lang['gr_poll_yes'] = "네";
$lang['gr_poll_no'] = "아니오";
$lang['gr_poll_ad_opened'] = "열려있음";
$lang['gr_poll_ad_closed'] = "차단됨";
$lang['gr_poll_ad_save'] = "저장됨";
$lang['gr_ad_adminonly'] = "차단된 요청 - 관리자만 볼 수 있습니다.";
$lang['gr_ad_delete'] = "삭제";
$lang['gr_ad_activate'] = "활성화";
$lang['gr_not_activated'] = "활성화된 요청이 아님:";
$lang['gr_no_requests'] = "현재 요청이 없습니다.";
$lang['gr_vr_ad_opened_f'] = "열려있음";
$lang['gr_vr_ad_opened'] = "요청이 열렸습니다.";
$lang['gr_vr_ad_closed_f'] = "차단됨";
$lang['gr_vr_ad_closed'] = "요청이 차단되었습니다.";
$lang['gr_vr_ad_activated_f'] = "활성화됨";
$lang['gr_vr_ad_activated'] = "요청이 활성화 되었습니다.";
$lang['gr_vr_ad_deleted_f'] = "삭제됨";
$lang['gr_vr_ad_deleted'] = "요청이 삭제되었습니다.";
$lang['gr_ad_config_headline'] = "요청 - 설정";
$lang['gr_ad_poll_activated'] = "투표가 활성화 되었습니다.";
$lang['gr_ad_headline_f'] = "환영 문구:";
$lang['gr_ad_mail1_f'] = "등록메일의 첫번째 부분:";
$lang['gr_ad_mail2_f'] = "등록메일의 두번째 부분:";
$lang['gr_ad_update_succ'] = "설정이 저장되었습니다!";
$lang['gr_ad_update_succ_hl'] = "성공!";
$lang['gr_pm_one_not_voted'] = "대기 투표가 있습니다.";
$lang['gr_pm_not_voted_1'] = " ";
$lang['gr_pm_not_voted_2'] = "대기 투표가 있습니다!";
$lang['gr_pu_new_query'] = "새로운 요청:";
$lang['gr_form_manage'] = "폼 편집하기";
$lang['gr_ad_form_singletext'] = "단문";
$lang['gr_ad_form_textfield'] = "텍스트필드";
$lang['gr_ad_form_dropdown'] = "드랍다운";
$lang['gr_ad_fieldname_f'] = "필드이름";
$lang['gr_ad_fieldtype_f'] = "필드타입";
$lang['gr_ad_requiredfield_f'] = "요구됨";
$lang['gr_ad_editdropdown'] = "옵션 편집";
$lang['gr_ad_editoptions'] = "옵션 편집";
$lang['gr_ad_succ_head'] = "변경사항이 저장됨";
$lang['gr_ad_succ_text'] = "변경사항이 성공적으로 저장되었습니다.";
$lang['gr_ad_err_dropdown'] = "필드이름을 선택하지 않으셨습니다.";
$lang['gr_ad_succ_del'] = "필드가 성공적으로 삭제되었습니다.";
$lang['gr_ad_sort_f'] = "정렬";
$lang['gr_ad_preview_f'] = "미리보기";
$lang['gr_vr_view'] = "지원서 보기";
$lang['gr_comment'] = "코멘트 쓰기";
$lang['gr_ad_closingmail'] = "지원자에게 알리기";
$lang['gr_ad_closingtext'] = "지원 결과가 나왔습니다. 결과는 다음과 같습니다:";
$lang['gr_ad_replyadress'] = "이 메일은 자동으로 생성됩니다. 회신은 다음 주소로 해주세요:";
$lang['gr_sendermail'] = "보낸 사람:";
$lang['gr_ad_popup_activated'] = "활성화 되지 않은 지원서가 있을때 팝업을 보시겠습니까? (메일 보내기가 되지 않을때만 필요합니다)";
$lang['gr_ad_notactivated_popup'] = "지원서가 활성화되지 않았습니다.";
$lang['gr_poll_voted_yet'] = "중간 결과";
$lang['gr_vote'] = "투표";
?>