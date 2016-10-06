<?php
/**
 * @package     System.BPPrettify
 *
 * @author		Artur Stępień
 * @email		artur.stepien@bestproject.pl
 * @copyright	(C) 2016 Bestproject. All rights reserved.
 * @license		GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 * @link		http://www.bestproject.pl
 */
defined('_JEXEC') or die;

/**
 * System plugin to use GooglePrettify as code highlighter.
 */
class PlgSystemBPPrettify extends JPlugin
{

	public function onAfterDispatch()
	{

		// Check that we are in the site application.
		if (JFactory::getApplication()->isAdmin()) {

			return true;
		}

		// Set the variables.
		$input = JFactory::getApplication()->input;

		// Check if the highlighter should be activated in this environment.
		if (JFactory::getDocument()->getType() !== 'html' || $input->get('tmpl', '',
				'cmd') === 'component') {
			return true;
		}

		// Add prettify script
		JHTML::_('jquery.framework');
		$doc = JFactory::getDocument();
		$doc->addScript('https://cdn.rawgit.com/google/code-prettify/master/src/prettify.js',
			null, true, true);
		$doc->addScriptDeclaration('
			jQuery(window).load(function(){
				var $list = jQuery("code,pre,xmp");
				if( $list.length ) {
					$list.addClass("prettyprint");
					prettyPrint();
				}
			});
		');

		// Add theme
		$theme = $this->params->get('theme', 'tomorrow.min.css');
		if ($theme !== '-1') {
			$doc->addStyleSheet('/plugins/system/bpprettify/themes/'.$theme);
		}

		return true;
	}
}