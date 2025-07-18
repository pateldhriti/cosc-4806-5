<?php require_once 'app/views/templates/header.php'; ?>
<div class="container">
    <h2>Edit Reminder</h2>

    <?php if (!isset($data['note']) || empty($data['note'])): ?>
        <div class="alert alert-danger">Reminder not found.</div>
    <?php else: ?>
        <form method="POST" action="/reminders/edit/<?= $data['note']['id'] ?>">
            <div class="mb-3">
                <label for="subject" class="form-label">Reminder Subject</label>
                <input type="text" name="subject" id="subject" class="form-control"
                       value="<?= htmlspecialchars($data['note']['subject']) ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Update</button>
            <a href="/reminders" class="btn btn-secondary">Cancel</a>
        </form>
    <?php endif; ?>
</div>
<?php require_once 'app/views/templates/footer.php'; ?>
