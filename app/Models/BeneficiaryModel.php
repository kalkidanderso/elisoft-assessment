<?php

namespace App\Models;

use CodeIgniter\Model;

class BeneficiaryModel extends Model
{
    protected $table = 'beneficiaries';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'beneficiary_id', 'full_name', 'age', 'gender', 'address', 
        'id_number', 'photo_path', 'household_id', 'status'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'full_name' => 'required|min_length[3]|max_length[100]',
        'age' => 'required|integer|greater_than[0]|less_than[150]',
        'gender' => 'required|in_list[male,female,other]',
        'address' => 'required|min_length[5]',
        'id_number' => 'permit_empty|is_unique[beneficiaries.id_number,id,{id}]',
    ];
    
    protected $validationMessages = [
        'full_name' => [
            'required' => 'Full name is required',
            'min_length' => 'Full name must be at least 3 characters',
        ],
        'age' => [
            'required' => 'Age is required',
            'integer' => 'Age must be a valid number',
        ],
        'gender' => [
            'required' => 'Gender is required',
        ],
        'address' => [
            'required' => 'Address is required',
        ],
        'id_number' => [
            'is_unique' => 'This ID number is already registered',
        ],
    ];

    /**
     * Generate unique Beneficiary ID
     */
    public function generateBeneficiaryId(): string
    {
        $year = date('Y');
        $count = $this->where('YEAR(registered_at)', $year)->countAllResults() + 1;
        return 'BEN-' . $year . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Check for duplicate beneficiaries based on name and ID
     */
    public function checkDuplicate(string $fullName, ?string $idNumber = null, ?int $excludeId = null): ?array
    {
        $builder = $this->where('full_name', $fullName);
        
        if ($idNumber) {
            $builder->orWhere('id_number', $idNumber);
        }
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->first();
    }

    /**
     * Get beneficiary with household information
     */
    public function getWithHousehold(int $id): ?array
    {
        return $this->select('beneficiaries.*, households.household_code, households.family_size, households.vulnerability_status')
            ->join('households', 'households.id = beneficiaries.household_id', 'left')
            ->where('beneficiaries.id', $id)
            ->first();
    }

    /**
     * Get all beneficiaries with household info
     */
    public function getAllWithHouseholds()
    {
        return $this->select('beneficiaries.*, households.household_code')
            ->join('households', 'households.id = beneficiaries.household_id', 'left')
            ->where('beneficiaries.deleted_at IS NULL')
            ->orderBy('beneficiaries.registered_at', 'DESC')
            ->findAll();
    }

    /**
     * Search beneficiaries by name or ID
     */
    public function search(string $query)
    {
        return $this->like('full_name', $query)
            ->orLike('beneficiary_id', $query)
            ->orLike('id_number', $query)
            ->where('deleted_at IS NULL')
            ->findAll();
    }
}
