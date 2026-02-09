<?php

namespace App\Controllers;

use App\Models\BeneficiaryModel;
use App\Models\HouseholdModel;
use CodeIgniter\Controller;

class Beneficiaries extends BaseController
{
    protected $beneficiaryModel;
    protected $householdModel;
    
    public function __construct()
    {
        $this->beneficiaryModel = new BeneficiaryModel();
        $this->householdModel = new HouseholdModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Beneficiaries',
            'page_title' => 'Beneficiary Management',
            'beneficiaries' => $this->beneficiaryModel->getAllWithHouseholds(),
        ];
        
        return view('beneficiaries/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Register Beneficiary',
            'page_title' => 'Register New Beneficiary',
            'households' => $this->householdModel->findAll(),
        ];
        
        return view('beneficiaries/create', $data);
    }

    public function store()
    {
        // Generate beneficiary ID
        $beneficiaryId = $this->beneficiaryModel->generateBeneficiaryId();
        
        $data = [
            'beneficiary_id' => $beneficiaryId,
            'full_name' => $this->request->getPost('full_name'),
            'age' => $this->request->getPost('age'),
            'gender' => $this->request->getPost('gender'),
            'address' => $this->request->getPost('address'),
            'id_number' => $this->request->getPost('id_number'),
            'household_id' => $this->request->getPost('household_id') ?: null,
            'status' => 'active',
        ];
        
        // Handle photo upload
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName = $beneficiaryId . '_' . $photo->getRandomName();
            $photo->move(WRITEPATH . 'uploads/beneficiaries', $newName);
            $data['photo_path'] = 'beneficiaries/' . $newName;
        }
        
        if ($this->beneficiaryModel->save($data)) {
            return redirect()->to('/beneficiaries')->with('success', 'Beneficiary registered successfully with ID: ' . $beneficiaryId);
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to register beneficiary');
        }
    }

    public function view($id)
    {
        $beneficiary = $this->beneficiaryModel->getWithHousehold($id);
        
        if (!$beneficiary) {
            return redirect()->to('/beneficiaries')->with('error', 'Beneficiary not found');
        }
        
        // Get projects enrolled
        $db = \Config\Database::connect();
        $projects = $db->table('beneficiary_projects bp')
            ->select('p.project_name, p.project_code, bp.enrollment_date, bp.participation_status')
            ->join('projects p', 'p.id = bp.project_id')
            ->where('bp.beneficiary_id', $id)
            ->get()
            ->getResultArray();
        
        // Get case notes
        $caseNotes = $db->table('case_notes cn')
            ->select('cn.*, u.full_name as worker_name')
            ->join('users u', 'u.id = cn.user_id')
            ->where('cn.beneficiary_id', $id)
            ->orderBy('cn.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $baseline = $db->table('baseline_data')
            ->where('beneficiary_id', $id)
            ->orderBy('assessment_date', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();

        $referrals = $db->table('referrals')
            ->where('beneficiary_id', $id)
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
        
        $data = [
            'title' => 'Beneficiary Profile',
            'page_title' => 'Beneficiary Profile',
            'beneficiary' => $beneficiary,
            'projects' => $projects,
            'caseNotes' => $caseNotes,
            'baseline' => $baseline,
            'referrals' => $referrals,
        ];
        
        return view('beneficiaries/view', $data);
    }

    public function baseline($id)
    {
        $beneficiary = $this->beneficiaryModel->find($id);
        if (!$beneficiary) {
            return redirect()->to('/beneficiaries')->with('error', 'Beneficiary not found');
        }

        $db = \Config\Database::connect();
        $baseline = $db->table('baseline_data')
            ->where('beneficiary_id', $id)
            ->orderBy('assessment_date', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();

        $data = [
            'title' => 'Baseline Data',
            'page_title' => 'Baseline & Socioeconomic Information',
            'beneficiary' => $beneficiary,
            'baseline' => $baseline,
        ];

        return view('beneficiaries/baseline', $data);
    }

    public function saveBaseline($id)
    {
        $beneficiary = $this->beneficiaryModel->find($id);
        if (!$beneficiary) {
            return redirect()->to('/beneficiaries')->with('error', 'Beneficiary not found');
        }

        $db = \Config\Database::connect();

        $data = [
            'beneficiary_id' => (int) $id,
            'education_level' => $this->request->getPost('education_level') ?: null,
            'health_status' => $this->request->getPost('health_status'),
            'livelihood_info' => $this->request->getPost('livelihood_info'),
            'nutrition_status' => $this->request->getPost('nutrition_status') ?: 'normal',
            'monthly_income' => $this->request->getPost('monthly_income') ?: 0,
            'assets' => $this->request->getPost('assets'),
            'assessment_date' => $this->request->getPost('assessment_date'),
        ];

        $db->table('baseline_data')->insert($data);

        return redirect()->to('/beneficiaries/view/' . $id)->with('success', 'Baseline data saved successfully');
    }

    public function addCaseNote($id)
    {
        $beneficiary = $this->beneficiaryModel->find($id);
        if (!$beneficiary) {
            return redirect()->to('/beneficiaries')->with('error', 'Beneficiary not found');
        }

        $db = \Config\Database::connect();
        $data = [
            'beneficiary_id' => (int) $id,
            'user_id' => (int) session()->get('user_id'),
            'note_type' => $this->request->getPost('note_type') ?: 'general',
            'content' => $this->request->getPost('content'),
            'follow_up_date' => $this->request->getPost('follow_up_date') ?: null,
        ];

        if (!$data['content']) {
            return redirect()->back()->withInput()->with('error', 'Case note content is required');
        }

        $db->table('case_notes')->insert($data);
        return redirect()->to('/beneficiaries/view/' . $id)->with('success', 'Case note added successfully');
    }

    public function addReferral($id)
    {
        $beneficiary = $this->beneficiaryModel->find($id);
        if (!$beneficiary) {
            return redirect()->to('/beneficiaries')->with('error', 'Beneficiary not found');
        }

        $db = \Config\Database::connect();
        $data = [
            'beneficiary_id' => (int) $id,
            'referral_type' => $this->request->getPost('referral_type') ?: 'other',
            'referred_to' => $this->request->getPost('referred_to'),
            'reason' => $this->request->getPost('reason'),
            'referral_date' => $this->request->getPost('referral_date'),
            'status' => $this->request->getPost('status') ?: 'pending',
            'outcome' => $this->request->getPost('outcome'),
        ];

        if (!$data['referred_to'] || !$data['reason'] || !$data['referral_date']) {
            return redirect()->back()->withInput()->with('error', 'Referral type, referred to, reason, and date are required');
        }

        $db->table('referrals')->insert($data);
        return redirect()->to('/beneficiaries/view/' . $id)->with('success', 'Referral recorded successfully');
    }

    public function edit($id)
    {
        $beneficiary = $this->beneficiaryModel->find($id);
        
        if (!$beneficiary) {
            return redirect()->to('/beneficiaries')->with('error', 'Beneficiary not found');
        }
        
        $data = [
            'title' => 'Edit Beneficiary',
            'page_title' => 'Edit Beneficiary',
            'beneficiary' => $beneficiary,
            'households' => $this->householdModel->findAll(),
        ];
        
        return view('beneficiaries/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'age' => $this->request->getPost('age'),
            'gender' => $this->request->getPost('gender'),
            'address' => $this->request->getPost('address'),
            'id_number' => $this->request->getPost('id_number'),
            'household_id' => $this->request->getPost('household_id') ?: null,
            'status' => $this->request->getPost('status'),
        ];
        
        // Handle photo upload
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $beneficiary = $this->beneficiaryModel->find($id);
            $newName = $beneficiary['beneficiary_id'] . '_' . $photo->getRandomName();
            $photo->move(WRITEPATH . 'uploads/beneficiaries', $newName);
            $data['photo_path'] = 'beneficiaries/' . $newName;
        }
        
        if ($this->beneficiaryModel->update($id, $data)) {
            return redirect()->to('/beneficiaries/view/' . $id)->with('success', 'Beneficiary updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update beneficiary');
        }
    }

    public function delete($id)
    {
        // Soft delete
        if ($this->beneficiaryModel->delete($id)) {
            return redirect()->to('/beneficiaries')->with('success', 'Beneficiary deleted successfully');
        } else {
            return redirect()->to('/beneficiaries')->with('error', 'Failed to delete beneficiary');
        }
    }
}
