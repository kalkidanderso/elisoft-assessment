<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <p class="mb-0">Total Beneficiaries</p>
                    <h3><?= number_format($stats['total_beneficiaries']) ?></h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <p class="mb-0">Active Projects</p>
                    <h3><?= number_format($stats['active_projects']) ?></h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <p class="mb-0">Pending Alerts</p>
                    <h3><?= number_format($stats['pending_alerts']) ?></h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-info bg-opacity-10 text-info">
                    <i class="fas fa-home"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <p class="mb-0">Total Households</p>
                    <h3><?= number_format($stats['total_households']) ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Beneficiaries -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Recently Registered Beneficiaries</h5>
        <a href="<?= base_url('beneficiaries') ?>" class="btn btn-primary btn-sm">
            View All <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body">
        <?php if (count($recentBeneficiaries) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Beneficiary ID</th>
                            <th>Full Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Registered Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentBeneficiaries as $beneficiary): ?>
                            <tr>
                                <td><strong><?= esc($beneficiary['beneficiary_id']) ?></strong></td>
                                <td><?= esc($beneficiary['full_name']) ?></td>
                                <td><?= esc($beneficiary['age']) ?></td>
                                <td>
                                    <span class="badge <?= $beneficiary['gender'] == 'male' ? 'bg-primary' : 'bg-danger' ?>">
                                        <?= ucfirst(esc($beneficiary['gender'])) ?>
                                    </span>
                                </td>
                                <td><?= date('M d, Y', strtotime($beneficiary['registered_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <p class="text-muted">No beneficiaries registered yet</p>
                <a href="<?= base_url('beneficiaries/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Register First Beneficiary
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
