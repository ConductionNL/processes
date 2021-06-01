<?php

// src/Controller/DefaultController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class UserController.
 */
class UserController extends AbstractController
{
    /**
     * @Route("/login", methods={"GET"})
     * @Template
     */
    public function login()
    {
        return [];
    }

    /**
     * @Route("/logout", methods={"GET"})
     * @Template
     */
    public function logout()
    {
        return [];
    }
}
