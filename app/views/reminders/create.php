<?php require_once 'app/views/includes/header.php'; ?>
<div class="container">
    <h2>Create Reminder</h2>
    <form method="POST" action="/reminders/create">
        <div class="mb-3">
            <label for="subject" class="form-label">Reminder</label>
            <input type="text" name="subject" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Reminder</button>
        <a href="/reminders" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?php require_once 'app/views/includes/footer.php'; ?>
