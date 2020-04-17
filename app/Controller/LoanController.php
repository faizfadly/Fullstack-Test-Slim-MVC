<?php

namespace App\FaizFadly\Controller;

use App\FaizFadly\Model\PurposeModel;

final class LoanController
{
    /**
     * Register a Loan.
     *
     * @param Slim\Http\Request  $request
     * @param Slim\Http\Response $response
     *
     * @return Slim\Http\Response
     */

    var $minLoan = 1000;
    var $maxLoan = 10000;
    
    public function register($request, $response)
    {
        $userData = $request->getParsedBody();
        $validate = $this->_register_validate($userData);
        $data = array();
        if(empty($validate)){
            if($this->write_file(json_encode($userData))){
                $data['status']=true;
                $data['message']="Data Berhasil disimpan";
            }else{
                $data['status']=false;
                $data['message']="Data Gagagl disimpan disimpan";
            }
            return $response->withJson($data, 200);
        }else{
            return $response->withJson($validate, 200);
        }
    }

    public function purpose(){
        return $user = PurposeModel::purpose();
    }

    function load_amount_validation($loan){
        $return = false;
        if($loan < $this->maxLoan && $this->minLoan > $this->minLoan){
            return true;
        }
    }

    function ktp_validation($ktp,$dateofbirth){
        $dmy = substr($ktp,6,6);
        $dd = substr($ktp,6,2); 
        $additional = 40;
        $fdateofbirth = date("dmy", strtotime($dateofbirth));

        if($dd>40){
            $getDate = substr($fdateofbirth,0,2);
            $realdate = $dd-40;
            return $realdate==$getDate ? true : false;
        }else{
            return $dmy==$fdateofbirth ? true : false;
        }
    }

    function _register_validate($request){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $ktp = $request['ktp'];
        $loan_periode = $request['loan_periode'];
        $loan_amount = $request['loan_amount'];
        $loan_purpose = $request['loan_purpose'];
        $date_of_birth = $request['date_of_birth'];
        $sex = $request['sex'];
    
        if(empty($first_name)){
            $data['inputerror'][] = 'first_name';
            $data['error_string'][] = 'First name canot be empty';
            $data['status'] = false;
        }

        if(empty($last_name)){
            $data['inputerror'][] = 'last_name';
            $data['error_string'][] = 'Last name canot be empty';
            $data['status'] = false;
        }

        if(empty($ktp)){
            $data['inputerror'][] = 'ktp';
            $data['error_string'][] = 'KTP canot be empty';
            $data['status'] = false;
        }

        if(empty($loan_periode)){
            $data['inputerror'][] = 'loan_periode';
            $data['error_string'][] = 'Loan periode canot be empty';
            $data['status'] = false;
        }

        if(empty($loan_purpose)){
            $data['inputerror'][] = 'loan_purpose';
            $data['error_string'][] = 'Loan purpose canot be empty';
            $data['status'] = false;
        }

        if(empty($date_of_birth)){
            $data['inputerror'][] = 'date_of_birth';
            $data['error_string'][] = 'Date of birth canot be empty';
            $data['status'] = false;
        }

        if(empty($sex)){
            $data['inputerror'][] = 'sex';
            $data['error_string'][] = 'Sex canot be empty';
            $data['status'] = false;
        }

        if(empty($loan_amount)){
            $data['inputerror'][] = 'seloan_amountx';
            $data['error_string'][] = 'Loan amount canot be empty';
            $data['status'] = false;
        }

        if($this->load_amount_validation($loan_amount)=='false'){
            $data['inputerror'][] = 'sex';
            $data['error_string'][] = 'Loan amount tidah boleh lebih kecil dari '.$this->minLoan.' dan lebih besar dari '.$this->maxLoan.'';
            $data['status'] = false;
        }

        if($this->ktp_validation($ktp,$date_of_birth)==false){
            $data['inputerror'][] = 'ktp';
            $data['error_string'][] = 'KTP is invalid';
            $data['status'] = false;
        }

        if($data['status'] === false)
        {
            return $data;
            exit();
        }
    }

    function write_file($data){
        $my_file = '../SavedData.txt';
        $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
        fwrite($handle, $data);
        if (fwrite($handle, $data) === FALSE) {
            return false;
            exit;
        }
        return true;
        fclose($handle);
    }


}