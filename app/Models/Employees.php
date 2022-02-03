<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'email',
        'password',
        'lastname',
        'company',
        'phone',

    ];

    /**
     * Fetch SINGLE employee's data
     * @param email
     */
    public function createEmployee($params){
        $data = [
            'firstname' => ucfirst(strtolower($params['firstname'])),
            'lastname' => ucfirst(strtolower($params['lastname'])),
            'email' => $params['email'],
            'phone' => $params['phone'],
            'company' => $params['companyId']
        ];

        $saveData = $this->updateOrCreate(['email' => $data['email']], $data);
        return ($saveData) ? $saveData : false;
    }

    /**
     * Fetch SINGLE employee's data
     * @param email
     */
    public function getEmployee($param){
        $data = $this->where('email', $param)->first();
        return ($data) ? $data : false;
    }

    /**
     * Fetch ALL Employee's data
     */
    public function getAllEmployees(){
        $data = $this->all();
        return ($data) ? $data : false;
    }

    /**
     * Fetch ALL Employee's data
     */
    public function getAllEmployeesByCompany($companyId){
        $data = $this->where('company', $companyId)->paginate(10);
        return ($data) ? $data : false;
    }

    /**
     * @param array[]
     */
    public function updateEmployee($params){
        $update = [
            'firstname' => $params['firstname'],
            'lastname' => $params['lastname'],
            'phone' => $params['phone']
        ];

        $updated = $this->where('email', $params['email'])->update($update);
        return ($updated) ? true : false;
    }

    /**
     * @param email
     */
    public function deleteEmployee($param){
        $updated = $this->where('email', $param)->delete();
        return ($updated) ? true : false;
    }


}
