<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\Roles;
use App\Helpers\Imaging;
use App\Helpers\Response;
use App\Models\Companies;
use App\Models\Employees;
use Illuminate\Http\Request;
use App\Helpers\RequestRules;
use App\Helpers\HttpStatusCodes;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountsController extends Controller {

    protected $userModel;
    protected $companyModel;
    protected $employeeModel;

    public function __construct(User $userModel, Companies $companyModel, Employees $employeeModel){
        $this->userModel = $userModel;
        $this->companyModel = $companyModel;
        $this->employeeModel = $employeeModel;
    }

    /**
     * This endpoint CREATES or UPDATES accounts!
     */

    public function createAccount(Request $request){
       try {
            $params = $request->all();

            if(!isset($params['role']) or empty($params['role'])){

                return $this->error('Role is not set!', HttpStatusCodes::UNPROCESSABLE_ENTITY);
            }

            $roles = config('roles.allowed_roles');
            if(!in_array($params['role'], $roles)){
                return $this->error('Roles can be either of: ' . implode(',', $array), HttpStatusCodes::UNPROCESSABLE_ENTITY);

            }

            $params['creator'] = $request->auth->id;

            $validator =  Validator::make($request->all(), RequestRules::getRule('CREATE_ADMIN_ACCOUNT'));
            if($validator->fails()) {
                return $this->error($validator->getMessageBag()->all(), HttpStatusCodes::UNPROCESSABLE_ENTITY);
            }

            // Mutate Variables
            $params['name'] = $params['firstname']. " " .$params['lastname'];
            $params['password'] = \Hash::make($params['password']);

            if($params['role'] == 'admin' and !is_action_permitted($request->auth->role, Roles::CREATE_ADMIN_ACCOUNT)){
                return $this->error('Insufficient Permissions', HttpStatusCodes::FORBIDDEN);
            }

            $create = $this->userModel->createUser($params);

            if($params['role'] == "employee"){
                if(is_action_permitted($request->auth->role, Roles::CREATE_EMPLOYEE_ACCOUNT)){

                    $validator =  Validator::make($request->all(), RequestRules::getRule('CREATE_EMPLOYEE_ACCOUNT'));
                    if($validator->fails()) {
                        return $this->error($validator->getMessageBag()->all(), HttpStatusCodes::UNPROCESSABLE_ENTITY);
                    }

                    // Mutate Variables
                    $params['password'] = \Hash::make($params['password']);

                    $create = $this->employeeModel->createEmployee($params);
                } else {
                    return $this->error('Insufficient Permissions', HttpStatusCodes::FORBIDDEN);
                }
            }

            if($params['role'] == "company"){
                if(is_action_permitted($request->auth->role, Roles::CREATE_COMPANY_ACCOUNT)){

                    $validator =  Validator::make($request->all(), RequestRules::getRule('CREATE_COMPANY_ACCOUNT'));
                    if($validator->fails()) {
                        return $this->error($validator->getMessageBag()->all(), HttpStatusCodes::UNPROCESSABLE_ENTITY);
                    }

                    // Mutate Variables
                    $params['password'] = \Hash::make($params['password']);
                    $params['logo'] = Imaging::saveImageFromBase64String($params['logo']);
                    $params['name'] = $params['firstname']. " " .$params['lastname'];
                    $create = $this->companyModel->createCompany($params);

                    if($create){
                        $details = [
                            'title' => 'Mail from test.com',
                            'body' => 'This is for to notify you that a company have been created'
                        ];

                        \Mail::to('admin@gmail.com')->send(new \App\Mail\Mailer($details));
                    }

                } else {
                    return $this->error('Insufficient Permissions', HttpStatusCodes::FORBIDDEN);
                }
            }

            if($create){

                $msg = ucwords($params['role']) . " Account Creation Successful";
                return $this->success($msg, HttpStatusCodes::OK, $create);
            } else {
                $msg = ucwords($params['role']) . "Account Creation Successful";
                return $this->error($msg, HttpStatusCodes::OK);
            }



        } catch(\Exception $e){
            return $this->error("Exception: " .$e->getMessage(), HttpStatusCodes::SERVER_ERROR);
        }
    }

    public function deleteAccount(Request $request){
        try{
            $params = $request->all();

            $validator =  Validator::make($request->all(), RequestRules::getRule('DELETE_ACCOUNT'));
            if($validator->fails()) {
                return $this->error($validator->getMessageBag()->all(), HttpStatusCodes::UNPROCESSABLE_ENTITY);
            }

            if(is_action_permitted($request->auth->role, Roles::DELETE_ACCOUNT)){
                $userDetails = $this->userModel->getUser($params['email']);

                if(!$userDetails){
                    return $this->error('User not found!', HttpStatusCodes::NOT_FOUND);
                }

                $deleted = $this->userModel->deleteUser($params['email']);
                if($userDetails['role'] == 'employee'){
                    $deleted = $this->employeeModel->deleteEmployee($params['email']);
                }

                if($userDetails['role'] == 'company'){
                    $deleted = $this->companyModel->deleteCompany($params['email']);
                    // Employee is already cascaded. On delete, employee data will also be removed.
                }

                if($deleted){
                    return $this->success('Account Deleted!', HttpStatusCodes::OK);
                } else {
                    return $this->error('Error: ', HttpStatusCodes::OK);
                }
            } else {
                return $this->error('Insufficient Permissions', HttpStatusCodes::FORBIDDEN);
            }


        } catch(\Exception $e){
            return $this->error("Exception: " .$e->getMessage(), HttpStatusCodes::SERVER_ERROR);
        }


    }


}
