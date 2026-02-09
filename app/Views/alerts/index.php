<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="fas fa-bell me-2"></i>System Alerts</h4>
    <form action="<?= base_url('alerts/generate') ?>" method="post">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa-sync me-2"></i>Generate Alerts
        </button>
    </form>
</div>

<div class="card">
    <div class="card-body">
        <?php if (count($alerts) > 0): ?>
            <?php foreach ($alerts as $alert): ?>
                <div class="alert alert-<?= $alert['priority'] == 'high' ? 'danger' : ($alert['priority'] == 'medium' ? 'warning' : 'info') ?> d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                    <div class="flex-grow-1">
                        <strong><?= esc($alert['full_name']) ?></strong> (<?= esc($alert['beneficiary_id']) ?>)
                        <p class="mb-0"><?= esc($alert['message']) ?></p>
                        <small class="text-muted"><?= date('M d, Y H:i', strtotime($alert['created_at'])) ?></small>
                    </div>
                    <span class="badge bg-<?= $alert['priority'] == 'high' ? 'danger' : 'warning' ?>">
                        <?= ucfirst($alert['priority']) ?>
                    </span>
                    <form action="<?= base_url('alerts/resolve/' . $alert['id']) ?>" method="post" class="ms-3">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-light btn-sm">
                            <i class="fas fa-check me-1"></i>Resolve
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted text-center py-5">No active alerts</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
