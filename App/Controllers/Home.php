<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

class Home extends Controller
{
    public function indexAction()
    {
        // View::render('Home/index.php', [
        //     'name' => 'John Doe',
        //     'colors' => ['red', 'green', 'blue']
        // ]);
        // echo ' Hello from Home controllers index method';

        View::renderTemplate('Home/index.html', [
            'name' => 'Dave',
            'colours' => ['red', 'green', 'blue']
        ]);
    }

    protected function before()
    {
        // echo 'before';
    }

    protected function after()
    {
        // echo 'after';
    }
}
