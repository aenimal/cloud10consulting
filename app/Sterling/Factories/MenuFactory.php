<?php namespace Sterling\Factories;

use \Config;
use \Menu;
use \View;
use \Auth;

class MenuFactory {
	
	public $no_auth = true;
	
	// build the menu from a config array
	// NOTE: only two levels at the moment, not recursive
	public function newMenu($configKey='main')
	{
		$this->menuKey = $configKey;

		$menus = Config::get('site.menus');
		$menuConfig = isset($menus[$this->menuKey]) ? $menus[$this->menuKey] : null;

		if($menuConfig){

			$m = Menu::handler($this->menuKey);

			$m->addClass($menuConfig['class'])
				->id($menuConfig['id']);

			foreach($menuConfig['items'] as $item)
			{
				if($item=='divider')
				{
					$m->raw(null,null,['class'=>'divider']);
				}else{
					$i = (object)$item;
					if($i->href=='') $i->href = 'javascript:;';
					// decide if this is a page or section (depending on if it has sub items)
					$pageOrSection = empty($i->items) ? 'page' : 'section';
					// check the user's permission
					if($this->no_auth || (
						Auth::user() && (
							Auth::user()->hasRole('super') || Auth::user()->can('see_'.$pageOrSection.'_' . $i->ref)
						)
					)){
					// if(Auth::user()->can('see_'.$pageOrSection.'_' . $i->ref)) { // No super user speciality
						// add the item
						$this->_addMenuItem($m, $i);
					}
				}
			}
			
			// add classes to items with children
			$m->getAllItems()->map(function($item){
				if($item->hasChildren()) $item->addClass('hasChild');
			});

			// add classes to all sub menus
			$m->getAllItemLists()->addClass('acc-menu');

			return $m;

		}else{
			die("MENU CONFIG NOT FOUND: '" . $this->menuKey."'");
		}
	}

	private function _addMenuItem($handler, $i)
	{
		// add the menu item
		//$handler->add($i->href, $i->label, null);
		$handler->add($i->href, $this->_menuLink('nav.menu_item_' . $this->menuKey . '_level0', $i->label, $i->icon), Menu::items($i->ref));

		// add the children
		if(!empty($i->items))
		{
			foreach($i->items as $sub)
			{
				//dd($sub);
				// check the user's permission
				if($this->no_auth || (Auth::user() && 						// has user object AND
					(
						Auth::user()->hasRole('super')		// is super user OR
						|| 
						(
							Auth::user()->can('see_section_' . $i->ref)	// must be able to see the parent section AND
							&&
							Auth::user()->can('see_page_' . $sub["ref"])	// must be able to see the specific page
						)
					))
				){
					$s = (object)$sub;
					$handler->find($i->ref)->add($s->href, $this->_menuLink('nav.menu_item_' . $this->menuKey . '_level1', $s->label));
				}
			}
		}
	}	

	// return a rendered view for a menu item
	private function _menuLink($view, $label, $icon='')
	{
		//return '<span>'.$label.'</span>';
		return View::make($view,['label'=>$label, 'icon'=>$icon])->render();
	}

}