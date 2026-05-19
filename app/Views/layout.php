<?php

declare(strict_types=1);

/** @var string $view */
/** @var array<string, mixed> $data */
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BE Opdracht 7</title>
    <style>
        :root {
            --bg: #f3efe7;
            --card: #fffdf8;
            --ink: #1f2933;
            --muted: #596675;
            --brand: #a63d40;
            --brand-dark: #7b2328;
            --line: #ddd3c5;
            --ok: #e8f6ef;
            --ok-text: #1d6b43;
            --warn: #fdf1e2;
            --warn-text: #8a4f12;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--ink);
            background:
                radial-gradient(circle at top right, rgba(166, 61, 64, 0.18), transparent 32%),
                linear-gradient(180deg, #f7f2e8 0%, var(--bg) 100%);
        }
        a { color: var(--brand); text-decoration: none; }
        a:hover { text-decoration: underline; }
        .shell {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 20px 48px;
        }
        .hero {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 24px;
            margin-bottom: 24px;
        }
        .hero h1 {
            margin: 0 0 8px;
            font-size: clamp(2rem, 3vw, 3rem);
        }
        .hero p {
            margin: 0;
            color: var(--muted);
            max-width: 680px;
        }
        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 14px 40px rgba(58, 47, 33, 0.08);
            padding: 24px;
        }
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px;
        }
        .chip {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            background: #efe6d7;
            color: #654d38;
            font-size: 0.95rem;
        }
        .alert {
            margin-bottom: 16px;
            padding: 14px 16px;
            border-radius: 12px;
        }
        .alert-success { background: var(--ok); color: var(--ok-text); }
        .alert-warning { background: var(--warn); color: var(--warn-text); }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 14px 10px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            vertical-align: top;
        }
        th { color: var(--muted); font-size: 0.95rem; }
        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .btn, button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 0;
            border-radius: 12px;
            padding: 11px 16px;
            background: var(--brand);
            color: #fff;
            font: inherit;
            cursor: pointer;
        }
        .btn:hover, button:hover { background: var(--brand-dark); text-decoration: none; }
        .btn-secondary {
            background: transparent;
            color: var(--brand);
            border: 1px solid var(--brand);
        }
        form {
            display: grid;
            gap: 18px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
        }
        label {
            display: grid;
            gap: 8px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid #c8b9a4;
            background: #fff;
            font: inherit;
        }
        .meta {
            color: var(--muted);
            font-size: 0.95rem;
        }
        .pagination {
            display: flex;
            gap: 12px;
            align-items: center;
            justify-content: end;
            margin-top: 18px;
        }
        .empty {
            padding: 24px;
            border-radius: 14px;
            background: #f8f4ed;
            color: var(--muted);
        }
        @media (max-width: 700px) {
            .hero { align-items: start; flex-direction: column; }
            .toolbar { flex-direction: column; align-items: start; }
            table, thead, tbody, th, td, tr { display: block; }
            thead { display: none; }
            tr {
                padding: 14px 0;
                border-bottom: 1px solid var(--line);
            }
            td {
                border: 0;
                padding: 8px 0;
            }
            td::before {
                content: attr(data-label);
                display: block;
                color: var(--muted);
                font-size: 0.9rem;
                margin-bottom: 4px;
            }
        }
    </style>
</head>
<body>
    <main class="shell">
        <?php require __DIR__ . '/' . $view . '.php'; ?>
    </main>
</body>
</html>
