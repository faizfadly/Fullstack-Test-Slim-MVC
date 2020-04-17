<?php

$app->get('/', function($request, $response) {
    $getPurpose = new  App\FaizFadly\Controller\LoanController;
    $setpurpose = $getPurpose->purpose();
    return $this->view->render($response, 'home.twig',$setpurpose);
});

$app->post('/register', "App\FaizFadly\Controller\LoanController:register");
