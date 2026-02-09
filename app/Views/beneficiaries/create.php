<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('beneficiaries') ?>">Beneficiaries</a></li>
        <li class="breadcrumb-item active">Register New</li>
    </ol>
</nav>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Register New Beneficiary</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('beneficiaries/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="full_name" class="form-label">Full Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="age" class="form-label">Age<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="age" name="age" min="1" max="150" required>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="gender" class="form-label">Gender<span class="text-danger">*</span></label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="id_number" class="form-label">ID Number</label>
                    <input type="text" class="form-control" id="id_number" name="id_number" placeholder="e.g., National ID, Passport">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="household_id" class="form-label">Household</label>
                    <select class="form-select" id="household_id" name="household_id">
                        <option value="">Select Household (Optional)</option>
                        <?php foreach ($households as $household): ?>
                            <option value="<?= $household['id'] ?>">
                                <?= esc($household['household_code']) ?> - <?= $household['family_size'] ?> members
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="address" class="form-label">Address<span class="text-danger">*</span></label>
                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
            </div>
            
            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                <small class="text-muted">Accepted formats: JPG, PNG. Max size: 2MB</small>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Register Beneficiary
                </button>
                <a href="<?= base_url('beneficiaries') ?>" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
