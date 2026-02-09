<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('projects') ?>">Projects</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
</nav>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 100px; height: 100px;">
                    <i class="fas fa-project-diagram fa-3x text-success"></i>
                </div>
                
                <h4 class="mb-1"><?= esc($project['project_name']) ?></h4>
                <p class="text-muted mb-3"><?= esc($project['project_code']) ?></p>
                
                <span class="badge bg-success mb-3">
                    <?= ucfirst(esc($project['status'])) ?>
                </span>
                
                <div class="d-grid gap-2">
                    <a href="<?= base_url('projects/edit/' . $project['id']) ?>" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Project
                    </a>
                    <a href="<?= base_url('projects') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Project Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <strong class="text-muted d-block">Description</strong>
                        <p class="mb-0"><?= esc($project['description']) ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="text-muted d-block">Location</strong>
                        <p class="mb-0"><?= esc($project['location']) ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="text-muted d-block">Budget</strong>
                        <p class="mb-0">$<?= number_format($project['budget'], 2) ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="text-muted d-block">Start Date</strong>
                        <p class="mb-0"><?= date('M d, Y', strtotime($project['start_date'])) ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="text-muted d-block">End Date</strong>
                        <p class="mb-0"><?= date('M d, Y', strtotime($project['end_date'])) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Enroll Beneficiary</h5>
            </div>
            <div class="card-body">
                <?php if (count($availableBeneficiaries) > 0): ?>
                    <form action="<?= base_url('projects/enroll/' . $project['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Beneficiary<span class="text-danger">*</span></label>
                                <select class="form-select" name="beneficiary_id" required>
                                    <option value="">Select beneficiary</option>
                                    <?php foreach ($availableBeneficiaries as $b): ?>
                                        <option value="<?= esc($b['id']) ?>"><?= esc($b['full_name']) ?> (<?= esc($b['beneficiary_id']) ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Enrollment Date</label>
                                <input type="date" class="form-control" name="enrollment_date" value="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="participation_status">
                                    <option value="enrolled">Enrolled</option>
                                    <option value="active">Active</option>
                                    <option value="completed">Completed</option>
                                    <option value="dropped_out">Dropped Out</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <input type="text" class="form-control" name="notes">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Enroll
                        </button>
                    </form>
                <?php else: ?>
                    <p class="text-muted mb-0">All beneficiaries are already enrolled (or none exist)</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-hand-holding-heart me-2"></i>Interventions / Services</h5>
            </div>
            <div class="card-body">
                <?php if (count($interventions) > 0): ?>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Service Type</th>
                                    <th>Description</th>
                                    <th>Budget</th>
                                    <th>Target</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($interventions as $i): ?>
                                    <tr>
                                        <td><?= ucfirst(str_replace('_', ' ', esc($i['service_type']))) ?></td>
                                        <td><?= esc($i['description']) ?></td>
                                        <td>$<?= number_format((float) $i['budget_allocated'], 2) ?></td>
                                        <td><?= esc($i['target_beneficiaries']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No interventions defined yet</p>
                <?php endif; ?>

                <form action="<?= base_url('projects/interventions/' . $project['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Service Type<span class="text-danger">*</span></label>
                            <select class="form-select" name="service_type" required>
                                <option value="cash_assistance">Cash Assistance</option>
                                <option value="food_aid">Food Aid</option>
                                <option value="iga_support">IGA Support</option>
                                <option value="training">Training</option>
                                <option value="education">Education</option>
                                <option value="health_subsidy">Health Services</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Budget Allocated (USD)</label>
                            <input type="number" class="form-control" name="budget_allocated" step="0.01" min="0" value="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Target Beneficiaries</label>
                            <input type="number" class="form-control" name="target_beneficiaries" min="0" value="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add Intervention
                    </button>
                </form>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Enrolled Beneficiaries</h5>
            </div>
            <div class="card-body">
                <?php if (count($beneficiaries) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Beneficiary ID</th>
                                    <th>Full Name</th>
                                    <th>Enrollment Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($beneficiaries as $beneficiary): ?>
                                    <tr>
                                        <td><?= esc($beneficiary['beneficiary_id']) ?></td>
                                        <td>
                                            <a href="<?= base_url('beneficiaries/view/' . $beneficiary['id']) ?>">
                                                <?= esc($beneficiary['full_name']) ?>
                                            </a>
                                        </td>
                                        <td><?= date('M d, Y', strtotime($beneficiary['enrollment_date'])) ?></td>
                                        <td><span class="badge bg-success"><?= ucfirst($beneficiary['participation_status']) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">No beneficiaries enrolled in this project yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
