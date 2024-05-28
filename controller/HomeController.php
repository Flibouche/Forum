<?php

namespace Controller;

use App\AbstractController;
use App\ControllerInterface;

class HomeController extends AbstractController implements ControllerInterface
{

    public function index()
    {
        return [
            "view" => VIEW_DIR . "home.php",
            "meta_description" => "Forum home page"
        ];
    }
}
