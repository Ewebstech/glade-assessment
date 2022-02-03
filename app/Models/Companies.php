<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
        'creator'
    ];

    /**
     *
     * @param $params
     */
    public function createCompany($params){
        $data = [
            'name' => ucfirst(strtolower($params['name'])),
            'email' => $params['email'],
            'logo' => $params['logo'],
            'website' => $params['website'],
            'creator' => $params['creator']
        ];

        $saveData = $this->updateOrCreate(['email' => $data['email']], $data);
        return ($saveData) ? $saveData : false;
    }

    /**
     * Fetch SINGLE company's data
     * @param email
     */
    public function getCompany($param){
        $data = $this->where('email', $param)->first();
        return ($data) ? $data : false;
    }

    /**
     * Fetch ALL Employee's data
     */
    public function getAllCompanies(){
        $data = $this->all();
        return ($data) ? $data : false;
    }

    /**
     * @param array[]
     */
    public function updateCompany($params){
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
    public function deleteCompany($param){
        $updated = $this->where('email', $param)->delete();
        return ($updated) ? true : false;
    }

}
