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

class EmployeeController extends Controller {

    protected $userModel;
    protected $companyModel;
    protected $employeeModel;

    public function __construct(User $userModel, Companies $companyModel, Employees $employeeModel){
        $this->userModel = $userModel;
        $this->companyModel = $companyModel;
        $this->employeeModel = $employeeModel;
    }

    public function viewEmployees(Request $request){
        if(is_action_permitted($request->auth->role, Roles::VIEW_EMPLOYEES)){
            if($request->auth->role == 'company'){
                $companyData = $this->companyModel->getCompany($request->auth->email);
                $data = $this->employeeModel->getAllEmployeesByCompany($companyData->id);
                return $this->success('Fetch Successful', HttpStatusCodes::OK, $data);
            } else {
                $data = $this->employeeModel->paginate(10);
                return $this->success('Fetch Successful', HttpStatusCodes::OK, $data);
            }
        } else {
            return $this->error('Insufficient Permissions', HttpStatusCodes::FORBIDDEN);
        }
    }



}
