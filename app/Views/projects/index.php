<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="fas fa-project-diagram me-2"></i>All Projects</h4>
    <a href="<?= base_url('projects/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Create New Project
    </a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (count($projects) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Project Code</th>
                            <th>Project Name</th>
                            <th>Start Date</th>
                            <th>Status</th>
                            <th>Budget</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td><strong><?= esc($project['project_code']) ?></strong></td>
                                <td><?= esc($project['project_name']) ?></td>
                                <td><?= date('M d, Y', strtotime($project['start_date'])) ?></td>
                                <td><span class="badge bg-success"><?= ucfirst($project['status']) ?></span></td>
                                <td>$<?= number_format($project['budget'], 2) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('projects/view/' . $project['id']) ?>" class="btn btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('projects/edit/' . $project['id']) ?>" class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted text-center py-5">No projects created yet</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
