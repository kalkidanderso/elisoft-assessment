<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('projects') ?>">Projects</a></li>
        <li class="breadcrumb-item active">Create New</li>
    </ol>
</nav>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-project-diagram me-2"></i>Create New Project</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('projects/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="project_name" class="form-label">Project Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="project_name" name="project_name" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="location" class="form-label">Location<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="e.g., Addis Ababa" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="start_date" class="form-label">Start Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="end_date" class="form-label">End Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="budget" class="form-label">Budget (USD)<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="budget" name="budget" step="0.01" min="0" required>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Create Project
                </button>
                <a href="<?= base_url('projects') ?>" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
