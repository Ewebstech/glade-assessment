<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    /**
     * Fetch SINGLE employee's data
     * @param email
     */
    protected function createEmployee($params){
        $data = [
            'firstname' => ucfirst(strtolower($params['firstname'])),
            'lastname' => ucfirst(strtolower($params['lastname'])),
            'email' => $params['email'],
            'role' => $params['role'],
            'phone' => $params['phone'],
            'company' => $params['companyId']
        ];

        $saveData = $this->create($data);
        return ($saveData) ? true : false;
    }

    /**
     * Fetch SINGLE employee's data
     * @param email
     */
    protected function getEmployee($param){
        $data = $this->where('email', $param)->first();
        return ($data) ? $data : false;
    }

    /**
     * Fetch ALL Employee's data
     */
    protected function getAllEmployees(){
        $data = $this->all();
        return ($data) ? $data : false;
    }

    /**
     * @param array[]
     */
    protected function updateEmployee($params){
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
    protected function deleteEmployee($param){
        $updated = $this->where('email', $param)->delete();
        return ($updated) ? true : false;
    }


}
