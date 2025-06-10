<?php

namespace core;
use core\Config;
class Controller
{
    protected Template $template;
    public $isPost = false;
    public $isGet = false;
    public $post;
    public $get;
    
    protected $errorMessages;
    public function __construct()
    {
        $action = Core::get()->actionName;
        $module = Core::get()->moduleName;
        $path = "views/{$module}/{$action}.php";
        $this->template = new Template($path);

        switch($_SERVER['REQUEST_METHOD'])
        {
            case 'POST':
                $this->isPost = true;
                break;
            case 'GET':
                $this->isGet = true;
                break;

        }
        $this->post = new Post();
        $this->get = new Get();
        $this->errorMessages = [];
    }
public function render(string $pathToView = null, array $params = []) : array
{
    if (!empty($pathToView))
        $this->template->setTemplateFilePath($pathToView);

    $this->template->setParams($params);

    return [
        'Content' => $this->template->getHTML()
    ];
}
protected function redirect(string $path)
{
  
$baseUrl = Config::get()->getBaseUrl(); 
    if (strpos($path, $baseUrl) === 0) {
        $url = $path;
    } else {
  
        $url = rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }
    header('Location: ' . $url);
    exit;
}
public function error(int $code = 404)
{
    http_response_code($code);
    $path = "views/errors/{$code}.php";

    if (file_exists($path)) {
        ob_start(); 
        include $path;
        $content = ob_get_clean(); 
        echo $content;
    } else {
        echo "$code - Помилка";
    }
    exit;
}
    public function addErrorMessage($message = null) : void
    {
        $this->errorMessages [] = $message; 
        $this->template->setParam('error_message', implode('<br>', $this->errorMessages));
    }
    public function clearErrorMessage() : void
    {
        $this->errorMessages = [];
        $this->template->setParam('error_message', null); 
    }
    public function isErrorMessageExist() : bool
    {
        return count($this->errorMessages) > 0;
    }
public function renderPartial($viewPath, $params = [])
{
    extract($params);
    ob_start();
    require $viewPath;
    return ob_get_clean();
}

    
}