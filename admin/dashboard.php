<?php
require_once __DIR__ . '/../inc/state.php';

// Redirect to login if not admin
if (!is_admin_logged_in()) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';

// Handle update of next numbers
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_next'])) {
    $inputs = [];
    for ($i = 0; $i < 5; $i++) {
        $val = isset($_POST['next'][$i]) ? trim($_POST['next'][$i]) : '';
        if ($val === '') {
            $error = 'All next numbers must be filled (number 1-200 or R).';
            break;
        }
        if (strtoupper($val) === 'R') {
            $inputs[] = 'R';
        } elseif (is_numeric($val) && intval($val) >= 1 && intval($val) <= 200) {
            $inputs[] = intval($val);
        } else {
            $error = 'Each next number must be an integer between 1 and 200, or "R" for random.';
            break;
        }
    }
    if (!$error) {
        set_admin_next_numbers($inputs);
        $success = 'Next number sequence updated successfully.';
    }
}

// Get generated numbers
$generated_numbers = get_generated_numbers();

// Get next 5 numbers (admin override or prediction)
$admin_next = get_admin_next_numbers();
if (!empty($admin_next)) {
    $next_numbers = array_slice($admin_next, 0, 5);
} else {
    $next_numbers = [];
    for ($i = 0; $i < 5; $i++) {
        $next_numbers[] = rand(1, 200);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Random Number Generator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            min-height: 100vh;
        }
        .card {
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        .number-badge {
            font-size: 1.5rem;
            margin: 0.25rem;
            padding: 0.75rem 1.25rem;
            border-radius: 1rem;
            background: #6366f1;
            color: #fff;
            display: inline-block;
        }
        .next-badge {
            background: #f59e42;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="text-primary mb-0">Admin Dashboard</h2>
                        <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
                    </div>
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <h5 class="mb-2">Generated Numbers (this session):</h5>
                    <div class="mb-3">
                        <?php if (empty($generated_numbers)): ?>
                            <span class="text-muted">No numbers generated yet.</span>
                        <?php else: ?>
                            <?php foreach ($generated_numbers as $num): ?>
                                <span class="number-badge"><?php echo htmlspecialchars($num); ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <h5 class="mb-2">Next 5 Numbers (editable):</h5>
                    <form method="post" class="row g-2 align-items-end mb-3">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <div class="col-6 col-md-2">
                                <input type="text" class="form-control next-input" name="next[]" value="<?php echo htmlspecialchars($next_numbers[$i]); ?>" required pattern="^([Rr]|[1-9][0-9]{0,2}|1[0-9]{2}|200)$" title='Enter 1-200 or "R" for random' placeholder='1-200 or R'>
                            </div>
                        <?php endfor; ?>
                        <div class="col-12 col-md-2">
                            <button type="submit" name="save_next" class="btn btn-warning w-100">Save</button>
                        </div>
                    </form>
                    <div class="alert alert-info small">
                        Enter a number (1-200) or "R" for random. Editing the next numbers will override the random generation for the next 5 numbers.
                    </div>
                    <div class="mt-4 text-center">
                        <a href="../index.php" class="btn btn-outline-primary btn-sm">Back to Public Page</a>
                    </div>
                </div>
                <div class="text-center mt-4 text-muted small">
                    &copy; <?php echo date('Y'); ?> SPL 5
                </div>
            </div>
        </div>
    </div>
</body>
</html>