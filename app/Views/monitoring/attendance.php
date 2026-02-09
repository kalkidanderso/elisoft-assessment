<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('monitoring') ?>">Monitoring</a></li>
        <li class="breadcrumb-item active">Attendance</li>
    </ol>
</nav>

<div class="row g-3">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Record Attendance</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('monitoring/attendance') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Beneficiary<span class="text-danger">*</span></label>
                        <select class="form-select" name="beneficiary_id" required>
                            <option value="">Select beneficiary</option>
                            <?php foreach ($beneficiaries as $b): ?>
                                <option value="<?= esc($b['id']) ?>"><?= esc($b['full_name']) ?> (<?= esc($b['beneficiary_id']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Project<span class="text-danger">*</span></label>
                        <select class="form-select" name="project_id" required>
                            <option value="">Select project</option>
                            <?php foreach ($projects as $p): ?>
                                <option value="<?= esc($p['id']) ?>"><?= esc($p['project_name']) ?> (<?= esc($p['project_code']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Event Type<span class="text-danger">*</span></label>
                            <select class="form-select" name="event_type" required>
                                <option value="training">Training</option>
                                <option value="community_event">Community Event</option>
                                <option value="distribution">Distribution</option>
                                <option value="meeting">Meeting</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Event Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="event_date" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="attendance_status">
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="excused">Excused</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Remarks</label>
                        <textarea class="form-control" name="remarks" rows="2"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Attendance
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Recent Attendance</h5>
            </div>
            <div class="card-body">
                <?php if (count($recentAttendance) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Beneficiary</th>
                                    <th>Project</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentAttendance as $row): ?>
                                    <tr>
                                        <td><?= esc($row['event_date']) ?></td>
                                        <td><?= esc($row['full_name']) ?> <small class="text-muted">(<?= esc($row['beneficiary_id']) ?>)</small></td>
                                        <td><?= esc($row['project_name']) ?> <small class="text-muted">(<?= esc($row['project_code']) ?>)</small></td>
                                        <td><?= ucfirst(str_replace('_', ' ', esc($row['event_type']))) ?></td>
                                        <td>
                                            <?php
                                            $colors = ['present' => 'success', 'absent' => 'danger', 'excused' => 'warning'];
                                            $c = $colors[$row['attendance_status']] ?? 'secondary';
                                            ?>
                                            <span class="badge bg-<?= $c ?>"><?= ucfirst(esc($row['attendance_status'])) ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">No attendance records yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
