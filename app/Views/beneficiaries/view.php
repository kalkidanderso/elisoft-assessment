<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('beneficiaries') ?>">Beneficiaries</a></li>
        <li class="breadcrumb-item active">Profile</li>
    </ol>
</nav>

<div class="row g-3">
    <!-- Profile Card -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <?php if ($beneficiary['photo_path']): ?>
                    <img src="<?= base_url('writable/uploads/' . $beneficiary['photo_path']) ?>" 
                         alt="<?= esc($beneficiary['full_name']) ?>" 
                         class="rounded-circle mb-3" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                <?php else: ?>
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 150px; height: 150px;">
                        <i class="fas fa-user fa-4x text-muted"></i>
                    </div>
                <?php endif; ?>
                
                <h4 class="mb-1"><?= esc($beneficiary['full_name']) ?></h4>
                <p class="text-muted mb-3"><?= esc($beneficiary['beneficiary_id']) ?></p>
                
                <?php
                $statusColors = [
                    'active' => 'success',
                    'inactive' => 'secondary',
                    'graduated' => 'info',
                    'suspended' => 'warning'
                ];
                $statusColor = $statusColors[$beneficiary['status']] ?? 'secondary';
                ?>
                <span class="badge bg-<?= $statusColor ?> mb-3">
                    <?= ucfirst(esc($beneficiary['status'])) ?>
                </span>
                
                <div class="d-grid gap-2">
                    <a href="<?= base_url('beneficiaries/edit/' . $beneficiary['id']) ?>" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Profile
                    </a>
                    <a href="<?= base_url('beneficiaries') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Baseline & Socioeconomic</h5>
                <a href="<?= base_url('beneficiaries/baseline/' . $beneficiary['id']) ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit me-2"></i>Update Baseline
                </a>
            </div>
            <div class="card-body">
                <?php if (!empty($baseline)): ?>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <strong class="text-muted d-block">Assessment Date</strong>
                            <div><?= esc($baseline['assessment_date']) ?></div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong class="text-muted d-block">Education</strong>
                            <div><?= $baseline['education_level'] ? ucfirst(esc($baseline['education_level'])) : '<span class="text-muted">Not set</span>' ?></div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong class="text-muted d-block">Nutrition</strong>
                            <div><?= $baseline['nutrition_status'] ? ucfirst(str_replace('_', ' ', esc($baseline['nutrition_status']))) : '<span class="text-muted">Not set</span>' ?></div>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">No baseline record yet. Click “Update Baseline” to add one.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Details Card -->
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Personal Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong class="text-muted d-block">Age</strong>
                        <p class="mb-0"><?= esc($beneficiary['age']) ?> years</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="text-muted d-block">Gender</strong>
                        <p class="mb-0"><?= ucfirst(esc($beneficiary['gender'])) ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="text-muted d-block">ID Number</strong>
                        <p class="mb-0"><?= $beneficiary['id_number'] ? esc($beneficiary['id_number']) : '<span class="text-muted">Not provided</span>' ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="text-muted d-block">Registered Date</strong>
                        <p class="mb-0"><?= date('M d, Y', strtotime($beneficiary['registered_at'])) ?></p>
                    </div>
                    <div class="col-12 mb-3">
                        <strong class="text-muted d-block">Address</strong>
                        <p class="mb-0"><?= esc($beneficiary['address']) ?></p>
                    </div>
                </div>
                
                <?php if ($beneficiary['household_code']): ?>
                    <div class="alert alert-info mb-0">
                        <strong><i class="fas fa-home me-2"></i>Household:</strong> 
                        <?= esc($beneficiary['household_code']) ?> 
                        (Family Size: <?= $beneficiary['family_size'] ?>, 
                        Vulnerability: <?= ucfirst($beneficiary['vulnerability_status']) ?>)
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Projects Enrolled -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-project-diagram me-2"></i>Projects Enrolled</h5>
            </div>
            <div class="card-body">
                <?php if (count($projects) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Project Code</th>
                                    <th>Project Name</th>
                                    <th>Enrollment Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projects as $project): ?>
                                    <tr>
                                        <td><?= esc($project['project_code']) ?></td>
                                        <td><?= esc($project['project_name']) ?></td>
                                        <td><?= date('M d, Y', strtotime($project['enrollment_date'])) ?></td>
                                        <td>
                                            <span class="badge bg-success">
                                                <?= ucfirst(esc($project['participation_status'])) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">Not enrolled in any projects yet</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Case Notes -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-clipboard me-2"></i>Case Notes</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('beneficiaries/case-notes/' . $beneficiary['id']) ?>" method="post" class="mb-4">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Note Type</label>
                            <select class="form-select" name="note_type">
                                <option value="general">General</option>
                                <option value="follow_up">Follow Up</option>
                                <option value="counseling">Counseling</option>
                                <option value="incident">Incident</option>
                                <option value="assessment">Assessment</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Follow-up Date</label>
                            <input type="date" class="form-control" name="follow_up_date">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content<span class="text-danger">*</span></label>
                        <textarea class="form-control" name="content" rows="2" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add Case Note
                    </button>
                </form>

                <?php if (count($caseNotes) > 0): ?>
                    <?php foreach ($caseNotes as $note): ?>
                        <div class="border-start border-4 border-primary ps-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <strong><?= ucfirst(esc($note['note_type'])) ?></strong>
                                <small class="text-muted"><?= date('M d, Y', strtotime($note['created_at'])) ?></small>
                            </div>
                            <p class="mb-1"><?= esc($note['content']) ?></p>
                            <small class="text-muted">By: <?= esc($note['worker_name']) ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">No case notes recorded</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-share-square me-2"></i>Referrals</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('beneficiaries/referrals/' . $beneficiary['id']) ?>" method="post" class="mb-4">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Referral Type<span class="text-danger">*</span></label>
                            <select class="form-select" name="referral_type" required>
                                <option value="health">Health</option>
                                <option value="psychosocial">Psychosocial</option>
                                <option value="legal">Legal</option>
                                <option value="education">Education</option>
                                <option value="livelihood">Livelihood</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Referral Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="referral_date" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Referred To<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="referred_to" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Outcome</label>
                            <input type="text" class="form-control" name="outcome">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason<span class="text-danger">*</span></label>
                        <textarea class="form-control" name="reason" rows="2" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add Referral
                    </button>
                </form>

                <?php if (count($referrals) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Referred To</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($referrals as $r): ?>
                                    <tr>
                                        <td><?= esc($r['referral_date']) ?></td>
                                        <td><?= ucfirst(esc($r['referral_type'])) ?></td>
                                        <td><?= esc($r['referred_to']) ?></td>
                                        <td><span class="badge bg-secondary"><?= ucfirst(str_replace('_', ' ', esc($r['status']))) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">No referrals recorded</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
