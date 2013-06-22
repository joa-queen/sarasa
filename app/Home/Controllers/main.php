<?php

use Sarasa\Core\Template;

class Controller extends Sarasa\Models\MainController {
	
	public function index()
	{
		$em = $this->getEntityManager();
		$template = new Template();

		$template->title('Home');
		$template->display('main.tpl');
	}
	
}
