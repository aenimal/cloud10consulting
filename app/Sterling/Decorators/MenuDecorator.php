<?php namespace Sterling\Decorators;

use \Menu;

class MenuDecorator{

	var $handler = null;
	
	public function setHandler(&$handler)
	{
		$this->handler = $handler;
	}

	public function activateMenuItem($item_ref)
	{
		if($this->handler)
		{
			// highlight the specified main item
			if($menuItem = $this->handler->find($item_ref)){
				$menuItem->getParent()->addClass('active');
			}
		}else{
			die("No menu handler set in MenuDecorator::activateMenuItem()");
		}
	}

}