<?php

namespace App\Controller;

class AbstractController
{
    /**
     * @param string $template
     * @param array $data
     * @return void
     */
    public function render(string $template, array $data = [])
    {
        ob_start();
        require __DIR__ . '/../View/' . $template . '.html.php';
        $html = ob_get_clean();
        require __DIR__ . '/../View/base.html.php';
    }

    /**
     * @param string $data
     * @return string
     */
    protected function clean(string $data): string
    {
        $data = trim($data);
        $data = strip_tags($data);
        $data = htmlentities($data);

        if ($data < 0 || $data > 100) {
            $data = 15;
        }

        return $data;
    }
}