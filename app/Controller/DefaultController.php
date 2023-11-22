<?php

namespace Desafiobis2bis\App\Controller;

use Desafiobis2bis\App\View\ViewInterface;

class DefaultController
{
    protected ViewInterface $view;

    public function __construct(ViewInterface $view) {
        $this->view = $view;
    }

    public function index()
    {
        $content = $this->view->render('home.php');
        echo $content;
    }

    public function post()
    {
        $content = $this->view->render('post.php');
        echo $content;
    }

    public function aboutUs()
    {
        $content = $this->view->render('aboutUs.php');
        echo $content;
    }

    public function register()
    {
        $content = $this->view->render('register.php');
        echo $content;
    }

    public function login()
    {
        $content = $this->view->render('login.php');
        echo $content;
    }

    public function logout()
    {
        $content = $this->view->render('logout.php');
        echo $content;
    }

    public function dashboard()
    {
        $content = $this->view->render('dashboard.php');
        echo $content;
    }

    public function account()
    {
        $content = $this->view->render('account.php');
        echo $content;
    }
    
    public function adminPostPage()
    {
        $content = $this->view->render('adminPostPage.php');
        echo $content;
    }

    public function adminUserPage()
    {
        $content = $this->view->render('adminUserPage.php');
        echo $content;
    }

    public function adminPage()
    {
        $content = $this->view->render('adminPage.php');
        echo $content;
    }
}