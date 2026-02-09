<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('projects') ?>">Projects</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Project</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('projects/update/' . $project['id']) ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="project_name" class="form-label">Project Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="project_name" name="project_name" value="<?= esc($project['project_name']) ?>" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="location" class="form-label">Location<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="location" name="location" value="<?= esc($project['location']) ?>" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?= esc($project['description']) ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="start_date" class="form-label">Start Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= esc($project['start_date']) ?>" required>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="end_date" class="form-label">End Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= esc($project['end_date']) ?>" required>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="budget" class="form-label">Budget (USD)<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="budget" name="budget" step="0.01" value="<?= esc($project['budget']) ?>" required>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="active" <?= $project['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="completed" <?= $project['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="suspended" <?= $project['status'] == 'suspended' ? 'selected' : '' ?>>Suspended</option>
                    </select>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Project
                </button>
                <a href="<?= base_url('projects/view/' . $project['id']) ?>" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
