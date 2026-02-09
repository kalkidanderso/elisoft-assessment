<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('beneficiaries') ?>">Beneficiaries</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Beneficiary</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('beneficiaries/update/' . $beneficiary['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="full_name" class="form-label">Full Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?= esc($beneficiary['full_name']) ?>" required>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="age" class="form-label">Age<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="age" name="age" value="<?= esc($beneficiary['age']) ?>" min="1" max="150" required>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="gender" class="form-label">Gender<span class="text-danger">*</span></label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="male" <?= $beneficiary['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= $beneficiary['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
                        <option value="other" <?= $beneficiary['gender'] == 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="id_number" class="form-label">ID Number</label>
                    <input type="text" class="form-control" id="id_number" name="id_number" value="<?= esc($beneficiary['id_number']) ?>">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="household_id" class="form-label">Household</label>
                    <select class="form-select" id="household_id" name="household_id">
                        <option value="">Select Household (Optional)</option>
                        <?php foreach ($households as $household): ?>
                            <option value="<?= $household['id'] ?>" <?= $beneficiary['household_id'] == $household['id'] ? 'selected' : '' ?>>
                                <?= esc($household['household_code']) ?> - <?= $household['family_size'] ?> members
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="address" class="form-label">Address<span class="text-danger">*</span></label>
                <textarea class="form-control" id="address" name="address" rows="3" required><?= esc($beneficiary['address']) ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="active" <?= $beneficiary['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $beneficiary['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        <option value="graduated" <?= $beneficiary['status'] == 'graduated' ? 'selected' : '' ?>>Graduated</option>
                        <option value="suspended" <?= $beneficiary['status'] == 'suspended' ? 'selected' : '' ?>>Suspended</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="photo" class="form-label">Update Photo</label>
                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                    <?php if ($beneficiary['photo_path']): ?>
                        <small class="text-muted">Current photo: <?= esc($beneficiary['photo_path']) ?></small>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Beneficiary
                </button>
                <a href="<?= base_url('beneficiaries/view/' . $beneficiary['id']) ?>" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
