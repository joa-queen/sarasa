<?php

require_once "../vendor/autoload.php";

use Sarasa\Core\FrontController;
use Sarasa\Core\Template;
use Sarasa\Core\AjaxResponse;
use Sarasa\Core\CustomException;
use Sarasa\Core\Lang;

$er = ((\Sarasa\Core\FrontController::config('production') || (isset($_SERVER['HTTP_AJAX_FUNCTION']) && $_SERVER['HTTP_AJAX_FUNCTION'] == 'debugbar')) ? 0 : E_ALL);
error_reporting($er);

session_start();

try {
    $action = FrontController::route();

    $controllername = FrontController::$bundle . '\Controllers\\' . FrontController::$controller;
    $controllereval = '$controller = new ' . $controllername . '();';
    eval($controllereval);

    if (isset($_SERVER['HTTP_AJAX_FUNCTION'])) {
        try {
            $function = $_SERVER['HTTP_AJAX_FUNCTION'];
            $parameters = $_POST;
            $url = $_SERVER['HTTP_AJAX_URL'];
            
            if (isset($parameters['debughash'])) {
                $controller->parenthash = $parameters['debughash'];
            }

            $objResponse = new AjaxResponse();
            $objResponse->script('stoploading();');
            
            if ($function == 'index') {
                throw new CustomException('Nombre de la función inválido.');
            }
            if (!method_exists($controllername, $function)) {
                throw new CustomException("No se encontró la función");
            }
        
            $func  = '$controller->' . $function . '($objResponse, $parameters);';
            eval($func);

            if (!FrontController::config('production') && $function != 'debugbar') {
                $objResponse->script('loaddebugbar("' . FrontController::$debugpath  . '/' . FrontController::$mtime . '");');
            }
        } catch (\Exception $e) {
            $objResponse->script('error("'.addslashes(str_replace("\n", "", nl2br($e->getMessage()))).'");');
        }
        
        echo $objResponse->toJSON();
    } else {
        try {
            $reflection = new ReflectionMethod($controllername, $action);
            $parameters = $reflection->getParameters();
            $params = array();

            foreach ($parameters as $parameter) {
                if (isset(FrontController::$parameters[$parameter->name])) {
                    $params[] = '\Sarasa\Core\FrontController::$parameters["' . $parameter->name . '"]';
                } else {
                    $params[] = 'null';
                }
            }

            $func = '$controller->' . $action . '(' . implode(', ', $params) . ');';
            if (!method_exists($controllername, $action)) {
                throw new CustomException("No se encontró la acción", 404);
            }
            eval($func);
        } catch (Exception $e) {
            FrontController::handlePageException($e);
        }
    }
    
} catch (Exception $e) {
    Template::error500($e);
}
