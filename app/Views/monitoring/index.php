<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h4><i class="fas fa-clipboard-check me-2"></i>Monitoring & Case Management</h4>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Attendance Tracking</h5>
            </div>
            <div class="card-body text-center py-5">
                <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-3">Record attendance for trainings and community events</p>
                <a href="<?= base_url('monitoring/attendance') ?>" class="btn btn-primary">
                    <i class="fas fa-arrow-right me-2"></i>Go to Attendance
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Case Notes</h5>
            </div>
            <div class="card-body text-center py-5">
                <i class="fas fa-notes-medical fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-3">Add case notes and referrals directly from each beneficiary profile</p>
                <a href="<?= base_url('beneficiaries') ?>" class="btn btn-outline-primary">
                    <i class="fas fa-users me-2"></i>Open Beneficiaries
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
