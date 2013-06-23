<?php

namespace Sarasa\Controllers;

use Sarasa\Core\Template;
use Sarasa\Core\CustomException;

class DebuggerController extends \Sarasa\Core\FrontController {
	
	public function index()
	{
		$file = $_SERVER['DOCUMENT_ROOT'] . '/../logs/dev/' . $_GET['dir1'] . '/' . $_GET['dir2'] . '/' . $_GET['time'] . '.json';
		if (parent::config('production') || !is_file($file)) throw new CustomException('No se encontró la página', 404);

		$json = file_get_contents($file);
		$data = json_decode($json, true);

		$template = new Template();

		$template->assign('data', $data);
		$template->display('debugger.tpl');
	}
	
}
