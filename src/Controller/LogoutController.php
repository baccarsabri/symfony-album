<?php

// src/Controller/LogoutController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class LogoutController extends AbstractController implements LogoutSuccessHandlerInterface
{
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(Request $request)
    {
        // This method will not be executed, as the logout process is handled by Symfony's security system.
    }

    /**
     * Handles the logout success event.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function onLogoutSuccess(Request $request)
    {
        // Your custom logout logic here (if needed)

        // Redirect the user to the login page after logout
        return $this->redirectToRoute('app_login');
    }
}

