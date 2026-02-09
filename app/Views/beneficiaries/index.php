<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="fas fa-users me-2"></i>All Beneficiaries
    </h4>
    <a href="<?= base_url('beneficiaries/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Register New Beneficiary
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="beneficiariesTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>Beneficiary ID</th>
                        <th>Full Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Household</th>
                        <th>Status</th>
                        <th>Registered Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($beneficiaries as $beneficiary): ?>
                        <tr>
                            <td><strong><?= esc($beneficiary['beneficiary_id']) ?></strong></td>
                            <td><?= esc($beneficiary['full_name']) ?></td>
                            <td><?= esc($beneficiary['age']) ?></td>
                            <td>
                                <span class="badge <?= $beneficiary['gender'] == 'male' ? 'bg-primary' : ($beneficiary['gender'] == 'female' ? 'bg-danger' : 'bg-secondary') ?>">
                                    <?= ucfirst(esc($beneficiary['gender'])) ?>
                                </span>
                            </td>
                            <td>
                                <?= $beneficiary['household_code'] ? esc($beneficiary['household_code']) : '<span class="text-muted">Not Assigned</span>' ?>
                            </td>
                            <td>
                                <?php
                                $statusColors = [
                                    'active' => 'success',
                                    'inactive' => 'secondary',
                                    'graduated' => 'info',
                                    'suspended' => 'warning'
                                ];
                                $statusColor = $statusColors[$beneficiary['status']] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?= $statusColor ?>">
                                    <?= ucfirst(esc($beneficiary['status'])) ?>
                                </span>
                            </td>
                            <td><?= date('M d, Y', strtotime($beneficiary['registered_at'])) ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= base_url('beneficiaries/view/' . $beneficiary['id']) ?>" 
                                       class="btn btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('beneficiaries/edit/' . $beneficiary['id']) ?>" 
                                       class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if (session()->get('role') == 'admin'): ?>
                                        <button type="button" 
                                                class="btn btn-danger" 
                                                title="Delete"
                                                onclick="deleteBeneficiary(<?= $beneficiary['id'] ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Form (hidden) -->
<form id="deleteForm" method="post" style="display: none;">
    <?= csrf_field() ?>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#beneficiariesTable').DataTables({
        pageLength: 25,
        order: [[6, 'desc']], // Sort by registered date
        responsive: true
    });
});

function deleteBeneficiary(id) {
    if (confirm('Are you sure you want to delete this beneficiary? This action cannot be undone.')) {
        const form = document.getElementById('deleteForm');
        form.action = '<?= base_url('beneficiaries/delete/') ?>' + id;
        form.submit();
    }
}
</script>
<?= $this->endSection() ?>
