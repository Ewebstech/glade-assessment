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

class CompanyController extends Controller {

    protected $userModel;
    protected $companyModel;
    protected $employeeModel;

    public function __construct(User $userModel, Companies $companyModel, Employees $employeeModel){
        $this->userModel = $userModel;
        $this->companyModel = $companyModel;
        $this->employeeModel = $employeeModel;
    }

    public function viewCompanies(Request $request){
        if($request->auth->role == 'employee'){
            $employeeData = $this->employeeModel->getEmployee($request->auth->email);
            $data = Companies::find($employeeData->company);
            return $this->success('Fetch Successful', HttpStatusCodes::OK, $data);
        } else {
            $data = $this->companyModel->paginate(10);
            return $this->success('Fetch Successful', HttpStatusCodes::OK, $data);
        }

    }



}
