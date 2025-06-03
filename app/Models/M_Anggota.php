<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Anggota extends Model
{
    protected $table = 'tbl_anggota';
    protected $primaryKey = 'id_anggota';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nama_anggota', 'email', 'no_tlp', 'alamat', 'jenis_kelamin', 'foto'];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function simpanDataAnggota($data)
    {
        return $this->insert($data);
    }

    public function hapusDataAnggota($where)
    {
        return $this->where($where)->delete();
    }

    public function ubahDataAnggota($data, $where)
    {
        return $this->where($where)->update($data);
    }
}
