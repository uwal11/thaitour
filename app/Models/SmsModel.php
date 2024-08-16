<?php
namespace App\Models;

use CodeIgniter\Model;

class SmsModel extends Model
{
    protected $table = 'tbl_auto_sms_skin';
    protected $primaryKey = 'idx'; 

    protected $allowedFields = ['code', 'title', 'content', 'autosend']; 

    public function getSms($offset, $limit)
    {
        return $this->orderBy('code', 'ASC')
                    ->findAll($limit, $offset);
    }
    public function countAll()
    {
        return $this->countAllResults();
    }
}
