<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function __construct()
    {
        // Ensure user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
    }

    public function index()
    {
        // Get statistics from database
        $db = \Config\Database::connect();
        
        $stats = [
            'total_beneficiaries' => $db->table('beneficiaries')->where('deleted_at IS NULL')->countAllResults(),
            'active_projects' => $db->table('projects')->where('status', 'active')->countAllResults(),
            'pending_alerts' => $db->table('alerts')->where('is_resolved', 0)->countAllResults(),
            'total_households' => $db->table('households')->countAllResults(),
        ];
        
        // Get recent beneficiaries
        $recentBeneficiaries = $db->table('beneficiaries')
            ->select('id, beneficiary_id, full_name, age, gender, registered_at')
            ->where('deleted_at IS NULL')
            ->orderBy('registered_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
        
        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Dashboard',
            'stats' => $stats,
            'recentBeneficiaries' => $recentBeneficiaries,
        ];
        
        return view('dashboard/index', $data);
    }
}
