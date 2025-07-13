<!DOCTYPE html>
<html lang="fa" dir="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>برنامه هفتگی</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            padding: 20px;
            background-color: #f4f7f6;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
        }
        thead th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }
        tbody th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        td {
            height: 60px;
            vertical-align: middle;
            transition: background-color 0.3s;
        }
        .class-cell {
            background-color: #eafaf1;
            font-weight: 500;
            color: #28a745;
        }
        .class-cell:hover {
            background-color: #d4edda;
        }
    </style>
</head>

<body>
    <h1>برنامه هفتگی</h1>
    <?php
        $schedule = $data['schedule'];

        $daysOfWeek = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنجشنبه'];
        $timeSlots = ['8-10', '10-12', '12-14', '14-16', '16-18', '18-20'];
    ?>
    <table dir="rtl">
        <thead>
            <tr>
                <th>روز / ساعت</th>
                <?php foreach ($timeSlots as $slot): ?>
                    <th><?php echo htmlspecialchars($slot); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($daysOfWeek as $day): ?>
                <tr>
                    <th><?php echo htmlspecialchars($day); ?></th>
                    <?php foreach ($timeSlots as $slot): ?>
                        <?php
                            // بررسی می‌کنیم آیا برای این روز و ساعت کلاسی تعریف شده است یا نه
                            if (isset($schedule[$day][$slot])) {
                                // اگر کلاس وجود داشت، آن را در یک سلول رنگی نمایش می‌دهیم
                                echo '<td class="class-cell">' . htmlspecialchars($schedule[$day][$slot]) . '</td>';
                            } else {
                                // در غیر این صورت، یک سلول خالی نمایش می‌دهیم
                                echo '<td></td>';
                            }
                        ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>
