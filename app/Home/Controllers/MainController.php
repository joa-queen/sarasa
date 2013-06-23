<?php

namespace Home\Controllers;

use Sarasa\Core\Template;

class MainController extends \Sarasa\Models\MainController {
	
	public function index()
	{
		$em = $this->getEntityManager();
		$template = new Template();

		$template->title('Home');
		$template->display('main.tpl');
	}
	
}
