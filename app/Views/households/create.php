<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('households') ?>">Households</a></li>
        <li class="breadcrumb-item active">Register New</li>
    </ol>
</nav>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-home me-2"></i>Register New Household</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('households/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="family_size" class="form-label">Family Size<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="family_size" name="family_size" min="1" required>
                    <small class="text-muted">Number of family members</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="vulnerability_status" class="form-label">Vulnerability Status<span class="text-danger">*</span></label>
                    <select class="form-select" id="vulnerability_status" name="vulnerability_status" required>
                        <option value="">Select Status</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="income_level" class="form-label">Income Level<span class="text-danger">*</span></label>
                    <select class="form-select" id="income_level" name="income_level" required>
                        <option value="">Select Income Level</option>
                        <option value="none">No Income</option>
                        <option value="very_low">Very Low</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="location" class="form-label">Location<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="e.g., Addis Ababa, Kirkos Sub-city" required>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Register Household
                </button>
                <a href="<?= base_url('households') ?>" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
