<?php
require_once __DIR__ . '/inc/state.php';

// No session-based initialization needed; state is global
// Handle new number generation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
    $admin_next_numbers = get_admin_next_numbers();
    if (!empty($admin_next_numbers) && is_array($admin_next_numbers)) {
        $next = array_shift($admin_next_numbers);
        if (strtoupper($next) === 'R') {
            $number = rand(1, 200);
        } else {
            $number = intval($next);
        }
        set_admin_next_numbers($admin_next_numbers); // Save updated override sequence
    } else {
        $number = rand(1, 200);
    }
    $generated_numbers = get_generated_numbers();
    $generated_numbers[] = $number;
    set_generated_numbers($generated_numbers);
    header('Location: index.php');
    exit;
}

// Handle reset lottery
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_lottery'])) {
    set_generated_numbers([]);
    // Optionally, also reset admin override sequence:
    // set_admin_next_numbers([]);
    header('Location: index.php');
    exit;
}

// For display: get generated numbers
$generated_numbers = get_generated_numbers();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Random Number Generator</title>
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
            <div class="col-lg-6 col-md-8">
                <div class="card p-4">
                    <h1 class="mb-4 text-center text-primary">Random Number Generator</h1>
                    <form method="post" class="text-center mb-4 d-flex flex-column flex-md-row justify-content-center gap-2">
                        <button type="submit" name="generate" class="btn btn-lg btn-success shadow-sm">
                            Generate New Number
                        </button>
                        <button type="submit" name="reset_lottery" class="btn btn-lg btn-danger shadow-sm" onclick="return confirm('Are you sure you want to reset the lottery? This will clear all generated numbers for this session.');">
                            Reset Lottery
                        </button>
                    </form>
                    <h4 class="mb-2">Generated Numbers (this session):</h4>
                    <div class="mb-3">
                        <?php if (empty($generated_numbers)): ?>
                            <span class="text-muted">No numbers generated yet.</span>
                        <?php else: ?>
                            <?php foreach ($generated_numbers as $num): ?>
                                <span class="number-badge"><?php echo htmlspecialchars($num); ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="text-center mt-4 text-muted small">
                    &copy; <?php echo date('Y'); ?> SPL 5 &mdash; Powered by PHP &amp; Bootstrap 5
                </div>
            </div>
        </div>
    </div>
</body>
</html>