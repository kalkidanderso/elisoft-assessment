<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('households') ?>">Households</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
</nav>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 100px; height: 100px;">
                    <i class="fas fa-home fa-3x text-primary"></i>
                </div>
                
                <h4 class="mb-1"><?= esc($household['household_code']) ?></h4>
                <p class="text-muted mb-3"><?= $household['family_size'] ?> Family Members</p>
                
                <?php
                $vulnColors = ['low' => 'success', 'medium' => 'warning', 'high' => 'danger', 'critical' => 'danger'];
                $vulnColor = $vulnColors[$household['vulnerability_status']] ?? 'secondary';
                ?>
                <span class="badge bg-<?= $vulnColor ?> mb-3">
                    <?= ucfirst(esc($household['vulnerability_status'])) ?> Vulnerability
                </span>
                
                <div class="d-grid gap-2">
                    <a href="<?= base_url('households/edit/' . $household['id']) ?>" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Household
                    </a>
                    <a href="<?= base_url('households') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Household Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong class="text-muted d-block">Family Size</strong>
                        <p class="mb-0"><?= $household['family_size'] ?> members</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="text-muted d-block">Income Level</strong>
                        <p class="mb-0"><?= ucfirst(str_replace('_', ' ', $household['income_level'])) ?></p>
                    </div>
                    <div class="col-12 mb-3">
                        <strong class="text-muted d-block">Location</strong>
                        <p class="mb-0"><?= esc($household['location']) ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="text-muted d-block">Registered Date</strong>
                        <p class="mb-0"><?= date('M d, Y', strtotime($household['created_at'])) ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Household Members</h5>
            </div>
            <div class="card-body">
                <?php if (count($household['beneficiaries']) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Beneficiary ID</th>
                                    <th>Full Name</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($household['beneficiaries'] as $beneficiary): ?>
                                    <tr>
                                        <td><?= esc($beneficiary['beneficiary_id']) ?></td>
                                        <td>
                                            <a href="<?= base_url('beneficiaries/view/' . $beneficiary['id']) ?>">
                                                <?= esc($beneficiary['full_name']) ?>
                                            </a>
                                        </td>
                                        <td><?= $beneficiary['age'] ?></td>
                                        <td><?= ucfirst($beneficiary['gender']) ?></td>
                                        <td><span class="badge bg-success"><?= ucfirst($beneficiary['status']) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">No beneficiaries assigned to this household yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
