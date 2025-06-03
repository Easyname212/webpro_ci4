<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Rak extends Model
{
    protected $table = 'tbl_rak';
    protected $primaryKey = 'id_rak';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['kode_rak', 'nama_rak', 'lokasi', 'keterangan'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

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
    protected $afterDelete = [];    public function getDataRak($where = false)
    {
        if ($where === false) {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->orderBy('nama_rak', 'ASC');
            return $builder->get();
        } else {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->where($where);
            $builder->orderBy('nama_rak', 'ASC');
            return $builder->get();
        }
    }    public function simpanDataRak($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function hapusDataRak($where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->delete();
    }

    public function ubahDataRak($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }
}
