<?php

namespace App\Controllers;

class Households extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $households = $db->table('households')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();
        
        $data = [
            'title' => 'Households',
            'page_title' => 'Household Management',
            'households' => $households,
        ];
        
        return view('households/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Household',
            'page_title' => 'Register New Household',
        ];
        
        return view('households/create', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $householdModel = new \App\Models\HouseholdModel();
        
        $data = [
            'household_code' => $householdModel->generateHouseholdCode(),
            'family_size' => $this->request->getPost('family_size'),
            'vulnerability_status' => $this->request->getPost('vulnerability_status'),
            'income_level' => $this->request->getPost('income_level'),
            'location' => $this->request->getPost('location'),
        ];
        
        $householdModel->save($data);
        
        return redirect()->to('/households')->with('success', 'Household registered successfully');
    }

    public function view($id)
    {
        $householdModel = new \App\Models\HouseholdModel();
        $household = $householdModel->getWithBeneficiaries($id);
        
        if (!$household) {
            return redirect()->to('/households')->with('error', 'Household not found');
        }
        
        $data = [
            'title' => 'Household Details',
            'page_title' => 'Household Details',
            'household' => $household,
        ];
        
        return view('households/view', $data);
    }

    public function edit($id)
    {
        $householdModel = new \App\Models\HouseholdModel();
        $household = $householdModel->find($id);
        
        if (!$household) {
            return redirect()->to('/households')->with('error', 'Household not found');
        }
        
        $data = [
            'title' => 'Edit Household',
            'page_title' => 'Edit Household',
            'household' => $household,
        ];
        
        return view('households/edit', $data);
    }

    public function update($id)
    {
        $householdModel = new \App\Models\HouseholdModel();
        
        $data = [
            'family_size' => $this->request->getPost('family_size'),
            'vulnerability_status' => $this->request->getPost('vulnerability_status'),
            'income_level' => $this->request->getPost('income_level'),
            'location' => $this->request->getPost('location'),
        ];
        
        if ($householdModel->update($id, $data)) {
            return redirect()->to('/households/view/' . $id)->with('success', 'Household updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update household');
        }
    }
}
