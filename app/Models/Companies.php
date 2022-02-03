<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    /**
     *
     * @param $params
     */
    protected function createCompany($params){
        $data = [
            'name' => ucfirst(strtolower($params['name'])),
            'email' => $params['email'],
            'logo' => $params['logo'],
            'website' => $params['website']
        ];

        $saveData = $this->create($data);
        return ($saveData) ? true : false;
    }

    /**
     * Fetch SINGLE company's data
     * @param email
     */
    protected function getCompany($param){
        $data = $this->where('email', $param)->first();
        return ($data) ? $data : false;
    }

    /**
     * Fetch ALL Employee's data
     */
    protected function getAllCompanies(){
        $data = $this->all();
        return ($data) ? $data : false;
    }

    /**
     * @param array[]
     */
    protected function updateCompany($params){
        $update = [
            'name' => $params['name'],
            'website' => $params['webiste'],
            'logo' => $params['logo']
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
