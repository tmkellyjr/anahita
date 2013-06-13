<?php
/** 
 * LICENSE: ##LICENSE##
 * 
 * @category   Anahita
 * @package    Com_Invites
 * @subpackage Adapter
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @version    SVN: $Id$
 * @link       http://www.anahitapolis.com
 */

/**
 * Invite Default Contorller
 *
 * @category   Anahita
 * @package    Com_Invites
 * @subpackage Adapter
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @link       http://www.anahitapolis.com
 */
class ComInvitesAdapterFacebook extends ComInvitesAdapterAbstract
{
    /**
     * An oauth session
     * 
     * @var ComConnectDomainEntitySession
     */
   	protected $_session = null;
	
   	/** 
   	 * Constructor.
   	 *
   	 * @param KConfig $config An optional KConfig object with configuration options.
   	 * 
   	 * @return void
   	 */ 
   	public function __construct(KConfig $config)
   	{
   	    parent::__construct($config);
   	    
   	    $this->_session = $config->session;
   	}
   	    
   	/**
   	 * Initializes the default configuration for the object
   	 *
   	 * Called from {@link __construct()} as a first step of object instantiation.
   	 *
   	 * @param KConfig $config An optional KConfig object with configuration options.
   	 *
   	 * @return void
   	 */
   	protected function _initialize(KConfig $config)
   	{
   	    $config->append(array(
   	
   	    ));
   	
   	    parent::_initialize($config);
   	} 
	
   	/**
   	 * Return an array of oauth users 
   	 * 
   	 * @return multitype:ComConnectOauthUser
   	 */
	public function getInvitables()
	{
		$friends = $this->_session->api->get('/me/friends');
		
		$users = array();
		
		foreach($friends['data'] as $friend)
		{
			$user = new ComConnectOauthUser();
			$user->id = $friend['id'];
			$user->name = $friend['name'];
			$user->thumb_avatar = 'https://graph.facebook.com/'.$friend['id'].'/picture';
			$users[] = $user;
		}
		
		return $users;
	}
}
