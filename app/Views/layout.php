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
            --warn: #fdf1e2;
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
            max-width: 1180px;
            margin: 0 auto;
            padding: 28px 24px 48px;
        }
        h1 {
            margin: 0 0 18px;
            font-size: 2rem;
            font-weight: 400;
            text-decoration: underline;
        }
        table, form, .meta-block, .toolbar, .flash, .empty, .pagination {
            background: var(--card);
        }
        .meta-block {
            margin: 0 0 18px;
            line-height: 1.8;
            font-size: 1.15rem;
            padding: 18px 20px;
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 14px 40px rgba(58, 47, 33, 0.08);
        }
        .meta-block strong {
            font-weight: 400;
        }
        .spacer {
            height: 14px;
        }
        .toolbar {
            display: flex;
            gap: 12px;
            align-items: center;
            margin: 12px 0 20px;
            flex-wrap: wrap;
        }
        .flash {
            margin: 0 0 16px;
            padding: 10px 12px;
            border: 1px solid var(--line);
            border-radius: 12px;
            box-shadow: 0 10px 28px rgba(58, 47, 33, 0.06);
        }
        .btn, button {
            display: inline-block;
            min-width: 120px;
            padding: 10px 18px;
            border: 1px solid var(--brand);
            border-radius: 12px;
            background: var(--brand);
            color: #fff;
            font: inherit;
            cursor: pointer;
            text-align: center;
            box-shadow: 0 8px 22px rgba(166, 61, 64, 0.18);
        }
        .btn:hover, button:hover { background: var(--brand-dark); text-decoration: none; }
        .btn-small {
            min-width: auto;
            padding: 6px 10px;
            font-size: 1.2rem;
            line-height: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 1px solid var(--line);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 14px 40px rgba(58, 47, 33, 0.08);
        }
        th, td {
            padding: 10px 12px;
            border: 1px solid var(--line);
            text-align: left;
            vertical-align: middle;
        }
        th {
            font-weight: 400;
            white-space: nowrap;
            color: var(--muted);
            background: #f7f1e7;
        }
        .icon-cell {
            text-align: center;
            width: 90px;
        }
        .icon-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            text-decoration: none;
            color: #111;
        }
        .icon-link svg {
            width: 30px;
            height: 30px;
            stroke: #111;
            fill: none;
            stroke-width: 1.9;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        .pagination {
            margin-top: 16px;
            display: flex;
            gap: 10px;
            align-items: center;
            padding: 14px 16px;
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 10px 28px rgba(58, 47, 33, 0.06);
        }
        .empty {
            margin-top: 10px;
            padding: 14px;
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 10px 28px rgba(58, 47, 33, 0.06);
        }
        form {
            max-width: 920px;
            padding: 24px;
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 14px 40px rgba(58, 47, 33, 0.08);
        }
        .form-row {
            display: grid;
            grid-template-columns: 220px 1fr;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }
        .form-row label {
            font-size: 1.1rem;
        }
        input[type="text"], select {
            width: 100%;
            max-width: 620px;
            padding: 10px 12px;
            border: 1px solid #c8b9a4;
            border-radius: 12px;
            background: #fff;
            font: inherit;
        }
        .inline-input {
            max-width: 260px !important;
        }
        .radio-group {
            display: flex;
            gap: 22px;
            align-items: center;
            flex-wrap: wrap;
            font-size: 1.05rem;
        }
        .radio-group label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .submit-row {
            margin-top: 30px;
        }
        @media (max-width: 820px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            th, td {
                font-size: 0.92rem;
                padding: 8px;
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
