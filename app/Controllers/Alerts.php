<?php

namespace App\Controllers;

class Alerts extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $alerts = $db->table('alerts a')
            ->select('a.*, b.beneficiary_id, b.full_name')
            ->join('beneficiaries b', 'b.id = a.beneficiary_id')
            ->where('a.is_resolved', 0)
            ->orderBy('a.created_at', 'DESC')
            ->get()
            ->getResultArray();
        
        $data = [
            'title' => 'Alerts',
            'page_title' => 'Alert Management',
            'alerts' => $alerts,
        ];
        
        return view('alerts/index', $data);
    }

    public function resolve($id)
    {
        $db = \Config\Database::connect();
        $db->table('alerts')
            ->where('id', $id)
            ->update([
                'is_resolved' => 1,
                'resolved_at' => date('Y-m-d H:i:s'),
            ]);

        return redirect()->to('/alerts')->with('success', 'Alert resolved');
    }

    public function generate()
    {
        $db = \Config\Database::connect();

        $today = date('Y-m-d');

        $overdue = $db->table('case_notes cn')
            ->select('cn.beneficiary_id, b.full_name, b.beneficiary_id as ben_code, cn.follow_up_date')
            ->join('beneficiaries b', 'b.id = cn.beneficiary_id')
            ->where('cn.follow_up_date IS NOT NULL')
            ->where('cn.follow_up_date <', $today)
            ->orderBy('cn.follow_up_date', 'ASC')
            ->limit(50)
            ->get()
            ->getResultArray();

        $created = 0;
        foreach ($overdue as $row) {
            $exists = $db->table('alerts')
                ->where('beneficiary_id', $row['beneficiary_id'])
                ->where('alert_type', 'overdue_followup')
                ->where('is_resolved', 0)
                ->countAllResults();

            if ($exists) {
                continue;
            }

            $db->table('alerts')->insert([
                'beneficiary_id' => (int) $row['beneficiary_id'],
                'alert_type' => 'overdue_followup',
                'message' => 'Overdue follow-up. Follow-up date was ' . $row['follow_up_date'],
                'priority' => 'high',
                'is_resolved' => 0,
            ]);
            $created++;
        }

        $highRisk = $db->table('beneficiaries b')
            ->select('b.id as beneficiary_id')
            ->join('households h', 'h.id = b.household_id', 'left')
            ->where('b.deleted_at IS NULL')
            ->whereIn('h.vulnerability_status', ['high', 'critical'])
            ->get()
            ->getResultArray();

        foreach ($highRisk as $row) {
            $exists = $db->table('alerts')
                ->where('beneficiary_id', $row['beneficiary_id'])
                ->where('alert_type', 'high_risk')
                ->where('is_resolved', 0)
                ->countAllResults();

            if ($exists) {
                continue;
            }

            $db->table('alerts')->insert([
                'beneficiary_id' => (int) $row['beneficiary_id'],
                'alert_type' => 'high_risk',
                'message' => 'High-risk case based on household vulnerability status.',
                'priority' => 'high',
                'is_resolved' => 0,
            ]);
            $created++;
        }

        $missingBaseline = $db->table('beneficiaries b')
            ->select('b.id as beneficiary_id')
            ->join('baseline_data bd', 'bd.beneficiary_id = b.id', 'left')
            ->where('b.deleted_at IS NULL')
            ->where('bd.id IS NULL')
            ->limit(200)
            ->get()
            ->getResultArray();

        foreach ($missingBaseline as $row) {
            $exists = $db->table('alerts')
                ->where('beneficiary_id', $row['beneficiary_id'])
                ->where('alert_type', 'missing_data')
                ->where('is_resolved', 0)
                ->countAllResults();

            if ($exists) {
                continue;
            }

            $db->table('alerts')->insert([
                'beneficiary_id' => (int) $row['beneficiary_id'],
                'alert_type' => 'missing_data',
                'message' => 'Missing baseline & socioeconomic information.',
                'priority' => 'medium',
                'is_resolved' => 0,
            ]);
            $created++;
        }

        return redirect()->to('/alerts')->with('success', 'Alert generation complete. New alerts: ' . $created);
    }
}
