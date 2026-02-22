<?php
$expression = isset($_POST['expression']) ? trim($_POST['expression']) : '';
$result = isset($_POST['result']) ? trim($_POST['result']) : '';

if ($expression === '' || $result === '') {
    header('Location: calculator.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator Result</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'SF Mono', 'Consolas', 'Monaco', monospace;
        }
        body {
            background: #0a0a0f;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        main {
            background: linear-gradient(145deg, #12121a 0%, #0d0d12 100%);
            padding: 40px;
            border-radius: 20px;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 0 40px rgba(0, 255, 204, 0.08);
            border: 1px solid rgba(0, 255, 204, 0.12);
        }
        h1 {
            color: #00ffcc;
            font-size: 20px;
            margin-bottom: 24px;
            font-weight: 600;
        }
        .message {
            color: #e0e0e0;
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 28px;
        }
        .message strong {
            color: #00ffcc;
        }
        .back {
            display: inline-block;
            padding: 12px 20px;
            background: #00ffcc;
            color: #000;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.2s ease;
        }
        .back:hover {
            box-shadow: 0 0 20px rgba(0, 255, 204, 0.4);
        }
    </style>
</head>
<body>
    <main>
        <h1>Calculation Result</h1>
        <p class="message">
            You entered <strong><?php echo htmlspecialchars($expression); ?></strong> and the answer is <strong><?php echo htmlspecialchars($result); ?></strong>.
        </p>
        <a href="calculator.php" class="back">← Back to Calculator</a>
    </main>
</body>
</html>
