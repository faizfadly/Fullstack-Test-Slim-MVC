<?php

namespace App\FaizFadly\Model;

//use Firebase\JWT\JWT;

final class PurposeModel
{
    /**
     * Register a Loan.
     *
     * @param Slim\Http\Request  $request
     * @param Slim\Http\Response $response
     *
     * @return Slim\Http\Response
     */
    public function purpose()
    {
        $purpose = array(
            array('name'=>'wedding'),
            array('name'=>'rent'),
            array('name'=>'car'),
            array('name'=>'invesment'),
        );
        
        $response = array(
            'purposes'=>$purpose
        );
        
        return $response;
    }

}