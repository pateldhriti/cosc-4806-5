<?php $this->view('includes/header'); ?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reports</li>
        </ol>
    </nav>

    <h2 class="mb-4">Admin Reports</h2>

    <!-- All Reminders Table -->
    <div class="card mb-4">
        <div class="card-header">All Reminders</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Reminder</th>
                        <th>User</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['reminders'] as $reminder): ?>
                        <tr>
                            <td><?= htmlspecialchars($reminder['subject']) ?></td>
                            <td><?= htmlspecialchars($reminder['username']) ?></td>
                            <td><?= htmlspecialchars($reminder['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top User -->
    <div class="alert alert-info">
        <strong>Top User:</strong> <?= htmlspecialchars($data['topUser']['username']) ?> with <?= $data['topUser']['total'] ?> reminders.
    </div>

    <!-- Login Stats -->
    <div class="card">
        <div class="card-header">Login Stats</div>
        <div class="card-body">
            <ul class="list-group">
                <?php foreach ($data['loginStats'] as $row): ?>
                    <li class="list-group-item">
                        <?= htmlspecialchars($row['username']) ?> - <?= $row['total'] ?> logins
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<?php $this->view('includes/footer'); ?>
