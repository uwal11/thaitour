<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductPlace extends Model
{
    protected $table = 'tbl_product_around_place';
    protected $primaryKey = 'idx';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        "name", "type", "distance", "ufile", "rfile", "product_idx", "onum", "r_date", "url",
    ];

    protected bool $allowEmptyInserts = false;

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
    protected $afterDelete = [];

    public function getById($idx)
    {
        $sql = " select * from tbl_product_around_place where idx = '" . $idx . "'";
        write_log($sql);
        return $this->db->query($sql)->getRowArray();
    }

    public function getByProductId($product_idx)
    {
        $sql = " select * from tbl_product_around_place where product_idx = '" . $product_idx . "' order by onum desc, idx desc";
        write_log($sql);
        return $this->db->query($sql)->getResultArray();
    }

    public function listAll()
    {
        $sql = " select * from tbl_product_around_place order by onum desc, idx desc";
        write_log($sql);
        return $this->db->query($sql)->getResultArray();
    }

    public function insertData($data)
    {
        $allowedFields = $this->allowedFields;

        $filteredData = array_filter(
            $data,
            function ($key) use ($allowedFields) {
                return in_array($key, $allowedFields);
            },
            ARRAY_FILTER_USE_KEY
        );

        foreach ($filteredData as $key => $value) {
            $filteredData[$key] = updateSQ($value);
        }

        return $this->insert($filteredData);
    }

    public function updateData($id, $data)
    {
        $allowedFields = $this->allowedFields;

        $filteredData = array_filter(
            $data,
            function ($key) use ($allowedFields) {
                return in_array($key, $allowedFields);
            },
            ARRAY_FILTER_USE_KEY
        );

        foreach ($filteredData as $key => $value) {
            $filteredData[$key] = updateSQ($value);
        }

        return $this->update($id, $filteredData);
    }

    public function deleteData($idx)
    {
        $this->delete($idx);
    }
}
