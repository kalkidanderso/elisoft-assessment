<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="fas fa-home me-2"></i>All Households</h4>
    <a href="<?= base_url('households/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Register New Household
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Household Code</th>
                        <th>Family Size</th>
                        <th>Vulnerability Status</th>
                        <th>Income Level</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($households as $household): ?>
                        <tr>
                            <td><strong><?= esc($household['household_code']) ?></strong></td>
                            <td><?= $household['family_size'] ?> members</td>
                            <td>
                                <?php
                                $vulnColors = ['low' => 'success', 'medium' => 'warning', 'high' => 'danger', 'critical' => 'danger'];
                                ?>
                                <span class="badge bg-<?= $vulnColors[$household['vulnerability_status']] ?>">
                                    <?= ucfirst(esc($household['vulnerability_status'])) ?>
                                </span>
                            </td>
                            <td><?= ucfirst(str_replace('_', ' ', $household['income_level'])) ?></td>
                            <td><?= esc($household['location']) ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= base_url('households/view/' . $household['id']) ?>" class="btn btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('households/edit/' . $household['id']) ?>" class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
