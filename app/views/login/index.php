<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Login</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<style>
				body {
						background-color: #f8f9fa;
				}
				.login-container {
						max-width: 400px;
						margin: 80px auto;
						padding: 20px;
						background-color: #fff;
						border-radius: 10px;
						box-shadow: 0 0 10px rgba(0,0,0,0.1);
				}
		</style>
</head>
<body>
		<div class="container login-container">
				<h2 class="text-center mb-4">Login</h2>

				<?php if (!empty($data['error'])): ?>
						<div class="alert alert-danger" role="alert">
								<?= $data['error'] ?>
						</div>
				<?php endif; ?>

				<form method="POST" action="/login/check">
						<div class="mb-3">
								<label for="username" class="form-label">Username</label>
								<input type="text" name="username" id="username" class="form-control" required>
						</div>
						<div class="mb-3">
								<label for="password" class="form-label">Password</label>
								<input type="password" name="password" id="password" class="form-control" required>
						</div>
						<button type="submit" class="btn btn-primary w-100">Login</button>
				</form>

				<div class="text-center mt-3">
						<a href="/login/create">Register here</a>
				</div>
		</div>
</body>
</html>
