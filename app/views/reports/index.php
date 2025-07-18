<?php $this->view('includes/header'); ?>

<div class="container mt-4">
    <!-- Breadcrumb -->
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
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Reminder</th>
                        <th>User</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['reminders'] as $reminder): ?>
                        <?php 
                            $highlight = ($reminder['username'] === $data['topUser']['username']) ? 'table-success' : ''; 
                        ?>
                        <tr class="<?= $highlight ?>">
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
    <?php if (!empty($data['topUser'])): ?>
      <div class="alert alert-info">
        <strong>🏆 Top User:</strong> <?= htmlspecialchars($data['topUser']['username']) ?> with <?= $data['topUser']['total'] ?> reminders.
      </div>
    <?php endif; ?>

    <!-- Login Stats -->
    <div class="card mb-4">
        <div class="card-header">Login Stats</div>
        <div class="card-body">
            <ul class="list-group">
                <?php foreach ($data['loginStats'] as $row): ?>
                    <li class="list-group-item">
                        <?= htmlspecialchars($row['username'] ?? 'Unknown') ?> - 
                        <?= isset($row['total']) ? htmlspecialchars($row['total']) : '0' ?> logins
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Login Chart -->
    <div class="card">
        <div class="card-header">Login Chart</div>
        <div class="card-body">
            <canvas id="loginChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('loginChart').getContext('2d');
        const loginChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($data['loginStats'], 'username')) ?>,
                datasets: [{
                    label: 'Logins',
                    data: <?= json_encode(array_column($data['loginStats'], 'total')) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>
<?php $this->view('includes/footer'); ?>
