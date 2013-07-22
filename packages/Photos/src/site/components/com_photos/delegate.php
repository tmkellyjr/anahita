<?php

/** 
 * LICENSE: Anahita is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 * 
 * @category   Anahita
 * @package    Com_Photos
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @version    SVN: $Id: view.php 13650 2012-04-11 08:56:41Z asanieyan $
 * @link       http://www.anahitapolis.com
 */

/**
 * App Delegate
 *
 * @category   Anahita
 * @package    Com_Photos
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @link       http://www.anahitapolis.com
 */
class ComPhotosDelegate extends ComAppsDomainDelegateDefault
{
    
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
            'default_assignments' => array('person'=>self::ASSIGNMENT_ALWAYS,'group'=>self::ASSIGNMENT_ALWAYS)
        ));
        
        parent::_initialize($config);
    }
        
	/**
	 * @{inheritdoc}
	 */
	protected function _setGadgets($actor, $gadgets, $mode)
	{
	    if ( $mode == 'profile' )
    		$gadgets->insert('photos-gadget', array(    			
    			'title' 		=> JText::_('COM-PHOTOS-GADGET-ACTOR-PROFILE'),
    			'url'   	    => 'option=com_photos&view=photos&layout=gadget&oid='.$actor->id,
                'action'        => JText::_('LIB-AN-GADGET-VIEW-ALL'),
    			'action_url'   	=> 'option=com_photos&view=photos&oid='.$actor->id
    		));
	    else
    		$gadgets->insert('photos-gadget', array(
    			'title' 	    => JText::_('COM-PHOTOS-GADGET-DASHBOARD'),
    			'url'   	    => 'option=com_photos&view=photos&filter=leaders&layout=gadget&oid='.$actor->id,
                'action'        => JText::_('LIB-AN-GADGET-VIEW-ALL'),
    			'action_url' 	=> 'option=com_photos&view=photos&filter=leaders&oid='.$actor->id,
    		));
	}
	
	/**
	 * @{inheritdoc}
	 */
	protected function _setComposers($actor, $composers, $mode)
	{
	    if ( $actor->authorize('action','com_photos:photo:add') )
	        $composers->insert('photo-composer', array(	                
	                'title'	       => JText::_('COM-PHOTOS-COMPOSER-PHOTO'),
	                'placeholder'  => JText::_('COM-PHOTOS-PHOTO-ADD'),
	                'url'      => 'option=com_photos&view=photo&layout=composer&oid='.$actor->id,
	        ));
	}
		
	/**
	 * Return a set of resources and type of operation on each resource
	 * 
	 * @return array
	 */
	public function getResources()
	{
		return array(
			'photo' => array('add','addcomment'),
			'set' => array('add','addcomment')
		);
	}

	/**
	 * Set the summerizers
	 * 
	 * @param  KCommandContext $context
	 * @return void
	 */
	public function setStoryOptions($context)
	{
		$context->append(array(
			'summarize' => array(
				'photo_add'		=>  'target'			
			),
			'commenting_off' => array()
		));
	}	
}