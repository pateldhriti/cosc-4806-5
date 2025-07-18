<?php require_once 'app/views/includes/header.php'; ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>My Reminders</h2>
        <a href="/reminders/create" class="btn btn-success">+ Create New Reminder</a>
    </div>

    <?php if (empty($data['reminders'])): ?>
        <div class="alert alert-info">
            You have no reminders yet.
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($data['reminders'] as $note): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?= htmlspecialchars($note['subject']) ?></strong>
                                <small class="text-muted ms-2">
                                    Created: <?= date("M d, Y h:i A", strtotime($note['created_at'])) ?>
                                </small>
                            </div>
                            <div>
                                <a href="/reminders/edit/<?= $note['id'] ?>" class="btn btn-sm btn-warning me-1">Edit</a>
                                <a href="/reminders/delete/<?= $note['id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this reminder?');">
                                   Delete
                                </a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php require_once 'app/views/templates/footer.php'; ?>
