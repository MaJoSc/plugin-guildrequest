<?php
/*
 * Project:     EQdkp guildrequest
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:        http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date: 2012-11-11 18:36:16 +0100 (So, 11. Nov 2012) $
 * -----------------------------------------------------------------------
 * @author      $Author: godmod $
 * @copyright   2008-2011 Aderyn
 * @link        http://eqdkp-plus.com
 * @package     guildrequest
 * @version     $Rev: 12434 $
 *
 * $Id: guildrequest_comments_save_hook.class.php 12434 2012-11-11 17:36:16Z godmod $
 */

if (!defined('EQDKP_INC'))
{
  header('HTTP/1.0 404 Not Found');exit;
}


/*+----------------------------------------------------------------------------
  | guildrequest_comments_save_hook
  +--------------------------------------------------------------------------*/
if (!class_exists('guildrequest_comments_save_hook'))
{
  class guildrequest_comments_save_hook extends gen_class
  {
    /* List of dependencies */
    public static $shortcuts = array('email' => 'MyMailer');

	/**
    * comments_save
    * Do the hook 'comments_save'
    *
    * @return array
    */
	public function comments_save($data)
	{
		//Return if there are no relevant comments
		if ($data['page'] != 'guildrequest') return $data;
		
		if (!$data['user_id']){
			if (registry::register('input')->exists('key')){
				register('pm');
				$row = registry::register('plus_datahandler')->get('guildrequest_requests', 'id', array($data['attach_id']));
				if($row['auth_key'] == registry::register('input')->get('key')) {
					$GRUserID 	= $this->pdh->get('user', 'userid', array('GuildRequest'));
					$data['user_id'] = $GRUserID;
					if ($GRUserID) $data['permission'] = true;
				}
			}
		} elseif($data['permission'] ) {
			//Email comment email to applicant
			register('pm');
			$row = $this->pdh->get('guildrequest_requests', 'id', array($data['attach_id']));
			if ($row){
				$server_url = $this->env->link.$this->routing->build('ViewApplication', $row['username'], $row['id'], false, true);
		
				$bodyvars = array(
						'USERNAME'		=> $row['username'],
						'U_ACTIVATE' 	=> $server_url . '?key=' . $row['auth_key'],
						'USER'			=> $this->pdh->get('user', 'name', array($data['user_id'])),
						'COMMENT'		=> $data['comment'],
				);
				$this->email->SendMailFromAdmin(register('encrypt')->decrypt($row['email']), $this->user->lang('gr_newcomment_subject'), $this->root_path.'plugins/guildrequest/language/'.$this->user->data['user_lang'].'/email/request_newcomment.html', $bodyvars);
			}
		}

		
		return $data;
	}
  }
}
?>