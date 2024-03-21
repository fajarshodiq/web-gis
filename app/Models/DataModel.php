<?php

namespace App\Models;

use CodeIgniter\Model;

class DataModel extends Model
{
    protected $table = "sanggar";
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_sanggar','nama_pimpinan', 'foto_sanggar', 'deskripsi', 'website', 'no_telp', 'latitude', 'longitude', 'slug'];
    protected $useTimestamps = FALSE;

    public function getSanggar($slug = "")
    {
        if ($slug == false) {
            return $this->findAll();
        }
        return $this->where(['slug' => $slug])->first();
    }

  

    public function cariSanggar($key)
    {
        return $this->like(['nama_sanggar' => $key])->orLike(['nama_pimpinan' => $key]);
    }
}
