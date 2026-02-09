<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('beneficiaries') ?>">Beneficiaries</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('beneficiaries/view/' . $beneficiary['id']) ?>">Profile</a></li>
        <li class="breadcrumb-item active">Baseline</li>
    </ol>
</nav>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Baseline & Socioeconomic Information</h5>
        <a href="<?= base_url('beneficiaries/view/' . $beneficiary['id']) ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Back to Profile
        </a>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <strong><?= esc($beneficiary['full_name']) ?></strong> (<?= esc($beneficiary['beneficiary_id']) ?>)
        </div>

        <?php if (!empty($baseline)): ?>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <strong class="text-muted d-block">Assessment Date</strong>
                    <div><?= esc($baseline['assessment_date']) ?></div>
                </div>
                <div class="col-md-4">
                    <strong class="text-muted d-block">Education</strong>
                    <div><?= $baseline['education_level'] ? ucfirst(esc($baseline['education_level'])) : '<span class="text-muted">Not set</span>' ?></div>
                </div>
                <div class="col-md-4">
                    <strong class="text-muted d-block">Nutrition</strong>
                    <div><?= $baseline['nutrition_status'] ? ucfirst(str_replace('_', ' ', esc($baseline['nutrition_status']))) : '<span class="text-muted">Not set</span>' ?></div>
                </div>
                <div class="col-md-6">
                    <strong class="text-muted d-block">Health</strong>
                    <div><?= $baseline['health_status'] ? esc($baseline['health_status']) : '<span class="text-muted">Not set</span>' ?></div>
                </div>
                <div class="col-md-6">
                    <strong class="text-muted d-block">Livelihood</strong>
                    <div><?= $baseline['livelihood_info'] ? esc($baseline['livelihood_info']) : '<span class="text-muted">Not set</span>' ?></div>
                </div>
                <div class="col-md-6">
                    <strong class="text-muted d-block">Monthly Income</strong>
                    <div>$<?= number_format((float) $baseline['monthly_income'], 2) ?></div>
                </div>
                <div class="col-md-6">
                    <strong class="text-muted d-block">Assets</strong>
                    <div><?= $baseline['assets'] ? esc($baseline['assets']) : '<span class="text-muted">Not set</span>' ?></div>
                </div>
            </div>
        <?php else: ?>
            <p class="text-muted">No baseline record yet. Add one below.</p>
        <?php endif; ?>

        <hr>

        <form action="<?= base_url('beneficiaries/baseline/' . $beneficiary['id']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Assessment Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="assessment_date" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Education Level</label>
                    <select class="form-select" name="education_level">
                        <option value="">Select</option>
                        <option value="none">None</option>
                        <option value="primary">Primary</option>
                        <option value="secondary">Secondary</option>
                        <option value="tertiary">Tertiary</option>
                        <option value="vocational">Vocational</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nutrition Status</label>
                    <select class="form-select" name="nutrition_status">
                        <option value="normal">Normal</option>
                        <option value="moderate_malnutrition">Moderate Malnutrition</option>
                        <option value="severe_malnutrition">Severe Malnutrition</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Health Status</label>
                <textarea class="form-control" name="health_status" rows="2" placeholder="e.g., chronic illness, disability, medical needs"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Livelihood Information</label>
                <textarea class="form-control" name="livelihood_info" rows="2" placeholder="e.g., employed, farming, unemployed, small business"></textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Monthly Income (USD)</label>
                    <input type="number" class="form-control" name="monthly_income" step="0.01" min="0" value="0">
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label">Assets</label>
                    <input type="text" class="form-control" name="assets" placeholder="e.g., livestock, tools, land, savings">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Save Baseline Record
            </button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
