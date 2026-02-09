<?php

namespace App\Controllers;

class Projects extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $projects = $db->table('projects')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();
        
        $data = [
            'title' => 'Projects',
            'page_title' => 'Project Management',
            'projects' => $projects,
        ];
        
        return view('projects/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Project',
            'page_title' => 'Create New Project',
        ];
        
        return view('projects/create', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        
        // Generate project code
        $count = $db->table('projects')->countAllResults() + 1;
        $projectCode = 'PROJ-' . date('Y') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        
        $data = [
            'project_code' => $projectCode,
            'project_name' => $this->request->getPost('project_name'),
            'description' => $this->request->getPost('description'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'status' => 'active',
            'location' => $this->request->getPost('location'),
            'budget' => $this->request->getPost('budget'),
        ];
        
        $db->table('projects')->insert($data);
        
        return redirect()->to('/projects')->with('success', 'Project created successfully');
    }

    public function view($id)
    {
        $db = \Config\Database::connect();
        $project = $db->table('projects')->where('id', $id)->get()->getRowArray();
        
        if (!$project) {
            return redirect()->to('/projects')->with('error', 'Project not found');
        }
        
        // Get enrolled beneficiaries
        $beneficiaries = $db->table('beneficiary_projects bp')
            ->select('b.id, b.beneficiary_id, b.full_name, bp.enrollment_date, bp.participation_status')
            ->join('beneficiaries b', 'b.id = bp.beneficiary_id')
            ->where('bp.project_id', $id)
            ->get()
            ->getResultArray();

        $enrolledIds = array_map(static fn ($row) => (int) $row['id'], $beneficiaries);

        $availableBuilder = $db->table('beneficiaries b')
            ->select('b.id, b.beneficiary_id, b.full_name')
            ->where('b.deleted_at IS NULL');

        if (!empty($enrolledIds)) {
            $availableBuilder->whereNotIn('b.id', $enrolledIds);
        }

        $availableBeneficiaries = $availableBuilder
            ->orderBy('b.full_name', 'ASC')
            ->get()
            ->getResultArray();

        $interventions = $db->table('interventions')
            ->where('project_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();
        
        $data = [
            'title' => 'Project Details',
            'page_title' => 'Project Details',
            'project' => $project,
            'beneficiaries' => $beneficiaries,
            'availableBeneficiaries' => $availableBeneficiaries,
            'interventions' => $interventions,
        ];
        
        return view('projects/view', $data);
    }

    public function enroll($id)
    {
        $db = \Config\Database::connect();
        $project = $db->table('projects')->where('id', $id)->get()->getRowArray();
        if (!$project) {
            return redirect()->to('/projects')->with('error', 'Project not found');
        }

        $beneficiaryId = (int) $this->request->getPost('beneficiary_id');
        if (!$beneficiaryId) {
            return redirect()->back()->withInput()->with('error', 'Please select a beneficiary');
        }

        $exists = $db->table('beneficiary_projects')
            ->where('beneficiary_id', $beneficiaryId)
            ->where('project_id', $id)
            ->countAllResults();

        if ($exists) {
            return redirect()->to('/projects/view/' . $id)->with('error', 'Beneficiary already enrolled in this project');
        }

        $db->table('beneficiary_projects')->insert([
            'beneficiary_id' => $beneficiaryId,
            'project_id' => (int) $id,
            'enrollment_date' => $this->request->getPost('enrollment_date') ?: date('Y-m-d'),
            'participation_status' => $this->request->getPost('participation_status') ?: 'enrolled',
            'notes' => $this->request->getPost('notes'),
        ]);

        return redirect()->to('/projects/view/' . $id)->with('success', 'Beneficiary enrolled successfully');
    }

    public function addIntervention($id)
    {
        $db = \Config\Database::connect();
        $project = $db->table('projects')->where('id', $id)->get()->getRowArray();
        if (!$project) {
            return redirect()->to('/projects')->with('error', 'Project not found');
        }

        $serviceType = $this->request->getPost('service_type');
        if (!$serviceType) {
            return redirect()->back()->withInput()->with('error', 'Service type is required');
        }

        $db->table('interventions')->insert([
            'project_id' => (int) $id,
            'service_type' => $serviceType,
            'description' => $this->request->getPost('description'),
            'budget_allocated' => $this->request->getPost('budget_allocated') ?: 0,
            'target_beneficiaries' => $this->request->getPost('target_beneficiaries') ?: 0,
        ]);

        return redirect()->to('/projects/view/' . $id)->with('success', 'Intervention added successfully');
    }

    public function edit($id)
    {
        $db = \Config\Database::connect();
        $project = $db->table('projects')->where('id', $id)->get()->getRowArray();
        
        if (!$project) {
            return redirect()->to('/projects')->with('error', 'Project not found');
        }
        
        $data = [
            'title' => 'Edit Project',
            'page_title' => 'Edit Project',
            'project' => $project,
        ];
        
        return view('projects/edit', $data);
    }

    public function update($id)
    {
        $db = \Config\Database::connect();
        
        $data = [
            'project_name' => $this->request->getPost('project_name'),
            'description' => $this->request->getPost('description'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'location' => $this->request->getPost('location'),
            'budget' => $this->request->getPost('budget'),
            'status' => $this->request->getPost('status'),
        ];
        
        if ($db->table('projects')->where('id', $id)->update($data)) {
            return redirect()->to('/projects/view/' . $id)->with('success', 'Project updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update project');
        }
    }
}
