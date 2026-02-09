<?php

namespace App\Models;

use CodeIgniter\Model;

class HouseholdModel extends Model
{
    protected $table = 'households';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'household_code', 'family_size', 'vulnerability_status', 
        'income_level', 'location'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    protected $validationRules = [
        'family_size' => 'required|integer|greater_than[0]',
        'vulnerability_status' => 'required|in_list[low,medium,high,critical]',
        'income_level' => 'required|in_list[none,very_low,low,medium,high]',
    ];

    /**
     * Generate unique Household Code
     */
    public function generateHouseholdCode(): string
    {
        $count = $this->countAll() + 1;
        return 'HH-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get household with beneficiaries
     */
    public function getWithBeneficiaries(int $id): ?array
    {
        $household = $this->find($id);
        
        if ($household) {
            $db = \Config\Database::connect();
            $household['beneficiaries'] = $db->table('beneficiaries')
                ->where('household_id', $id)
                ->where('deleted_at IS NULL')
                ->get()
                ->getResultArray();
        }
        
        return $household;
    }
}
