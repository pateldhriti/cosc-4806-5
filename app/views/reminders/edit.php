<?php $this->view('includes/header'); ?>

<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/reminders">Reminders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Reminder</li>
        </ol>
    </nav>

    <h2>Edit Reminder</h2>

    <?php if (!empty($data['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($data['error']) ?></div>
    <?php endif; ?>

    <form method="POST" action="/reminders/edit/<?= $data['reminder']['id'] ?>">
        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" name="subject" class="form-control" id="subject"
                   value="<?= htmlspecialchars($data['reminder']['subject'] ?? '') ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="/reminders" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php $this->view('includes/footer'); ?>
