<?php

namespace App\Controllers;

class Monitoring extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Monitoring',
            'page_title' => 'Monitoring & Case Management',
        ];
        
        return view('monitoring/index', $data);
    }

    public function attendance()
    {
        $db = \Config\Database::connect();

        $beneficiaries = $db->table('beneficiaries')
            ->select('id, beneficiary_id, full_name')
            ->where('deleted_at IS NULL')
            ->orderBy('full_name', 'ASC')
            ->get()
            ->getResultArray();

        $projects = $db->table('projects')
            ->select('id, project_code, project_name')
            ->orderBy('project_name', 'ASC')
            ->get()
            ->getResultArray();

        $recent = $db->table('attendance a')
            ->select('a.*, b.beneficiary_id, b.full_name, p.project_code, p.project_name')
            ->join('beneficiaries b', 'b.id = a.beneficiary_id')
            ->join('projects p', 'p.id = a.project_id')
            ->orderBy('a.event_date', 'DESC')
            ->limit(20)
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Attendance',
            'page_title' => 'Attendance Tracking',
            'beneficiaries' => $beneficiaries,
            'projects' => $projects,
            'recentAttendance' => $recent,
        ];

        return view('monitoring/attendance', $data);
    }

    public function storeAttendance()
    {
        $db = \Config\Database::connect();

        $beneficiaryId = (int) $this->request->getPost('beneficiary_id');
        $projectId = (int) $this->request->getPost('project_id');
        $eventType = $this->request->getPost('event_type');
        $eventDate = $this->request->getPost('event_date');
        $status = $this->request->getPost('attendance_status') ?: 'absent';

        if (!$beneficiaryId || !$projectId || !$eventType || !$eventDate) {
            return redirect()->back()->withInput()->with('error', 'Beneficiary, project, event type, and date are required');
        }

        $db->table('attendance')->insert([
            'beneficiary_id' => $beneficiaryId,
            'project_id' => $projectId,
            'event_type' => $eventType,
            'event_date' => $eventDate,
            'attendance_status' => $status,
            'remarks' => $this->request->getPost('remarks'),
        ]);

        return redirect()->to('/monitoring/attendance')->with('success', 'Attendance recorded successfully');
    }
}
