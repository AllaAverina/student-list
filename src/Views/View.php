<?php

namespace StudentList\Views;

class View
{
    private $templatesPath;

    public function __construct(string $templatesPath = __DIR__ . '/../../templates/')
    {
        $this->templatesPath = $templatesPath;
    }

    public function renderHtml(string $templateName, string $layoutName, array $vars = []): void
    {
        $template = $this->templatesPath . $templateName . '.php';

        extract($vars);

        ob_start();
        include $template;
        $content = ob_get_clean();

        if ($layoutName !== null) {
            $layout = $this->templatesPath . 'layouts/' . $layoutName . '.php';
            include $layout;
        } else {
            echo $content;
        }
    }

    public function renderError(int $code): void
    {
        http_response_code($code);

        $title = "Ошибка $code";
        $template = $this->templatesPath . 'errors/' . $code . '.php';
        $layout =  $this->templatesPath . 'layouts/default.php';

        ob_start();
        include $template;
        $content = ob_get_clean();
        include $layout;
        exit;
    }
}
