<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Calender</title>
    <link rel="stylesheet" href="reset.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&family=Roboto&display=swap&family=Fredoka+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body onload="startTime()">
    <?php
    $this_day = date("d");
    $this_year = date("Y");
    $this_month = date("n");
    if (isset($_GET["year"])) {
        $year =  $_GET["year"];
    } else {
        $year = $this_year;
    }
    if (isset($_GET["month"])) {
        $month =  $_GET["month"];
    } else {
        $month = $this_month;
    }

    ?>
    <div class="wrap">
        <div class="wrap_text">
            <span><?= $year ?> , </span>
            <span><?= date('F', mktime(0, 0, 0, $month)) ?></span>
        </div>
        <img src="https://i.imgur.com/IlRhXr5.gif" class="wrap_bg" alt="bg2">
        
    </div>
    <div class="container">
        <div class="time"><?= $this_year . " / " . $this_month . " / " . $this_day ?></div>
        <div id="clock"></div>
        <?php

        $firstday = date("w", strtotime(date("$year-$month-01")));
        $lastday  = date("t", strtotime(date("$year-$month-d")));

        if ($month + 1 >= 13) {
            $mnext = 1;
            $ynext = $year + 1;
        } else {
            $mnext = $month + 1;
            $ynext = $year;
        }

        if ($month - 1 <= 0) {
            $mlast = 12;
            $ylast = $year - 1;
        } else {
            $mlast = $month - 1;
            $ylast = $year;
        }

        ?>

        <table>
            <tr>
                <td>SUN</td>
                <td>MON</td>
                <td>TUE</td>
                <td>WED</td>
                <td>THU</td>
                <td>TUR</td>
                <td>SAT</td>
            </tr>
            <?php
            $is_this_month = ($year == $this_year && $month == $this_month);
            for ($i = 0; $i < 6; $i++) {
                echo "<tr>";
                for ($j = 0; $j < 7; $j++) {
                    if ($i == 0 && $j < $firstday) {
                        echo "<td>";
                        echo "</td>";
                    } else {
                        $day = $i * 7 + $j + 1  - $firstday;
                        if ($day > $lastday) {
                            echo "<td>";
                        } else {
                            if ($is_this_month && ($day == $this_day)) {
                                echo "<td>" . "<span class='today'>" . $day . "</span>";
                            } else {
                                echo "<td>" . $day;
                            }
                        }
                        echo "</td>";
                    }
                }
                echo "</tr>";
            }
            echo "</table>";
            ?>

            <div class="btn">
                    <a class="lastM" href="calendar.php?year=<?= $ylast ?>&month=<?= $mlast ?>">Last month</a>
                    <form action="?" method="get">
                <div class="selec">
                    <span>西元</span>
                    <select name="year" id="">
                        <?php
                        for ($j = 100; $j >= 0; $j--) {
                            $upY = $year - $j;
                            echo "<option value='$upY'>" . $upY . "</option>";
                        }
                        echo "<option value='$year' selected>" . $year . "</option>";
                        for ($i = 1; $i <= 100; $i++) {
                            $nextY = $year + $i;
                            echo "<option value='$nextY'>" . $nextY . "</option>";
                        }
                        ?>
                    </select>
                    <span>年</span>
                    <select name="month" id="">
                        <?php
                        for ($j = 1; $j <= $month - 1; $j++) {
                            echo "<option value='$j'>" . $j . "</option>";
                        }
                        echo "<option value='$month' selected>" . $month . "</option>";
                        for ($i = $month + 1; $i < 13; $i++) {
                            echo "<option value='$i'>" . $i . "</option>";
                        }
                        ?>
                    </select>
                    <span>月</span>
                    <input type="submit" value="查詢">
                    </form>
                </div>
                <a class="nextM" href="calendar.php?year=<?= $ynext ?>&month=<?= $mnext ?>">Next month</a>
                <a class="thisM" href="calendar.php">本月</a>
            </div>
    </div>


    <script>
        function startTime() {
            var today = new Date();
            var hh = today.getHours();
            var mm = today.getMinutes();
            var ss = today.getSeconds();
            mm = checkTime(mm);
            ss = checkTime(ss);
            document.getElementById('clock').innerHTML = hh + " : " + mm + " : " + ss;
            var timeoutId = setTimeout(startTime, 500);
        }
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
    </script>

</body>

</html>