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
    <div class="time_now">
        <div class="time"><?= $this_year . " / " . $this_month . " / " . $this_day ?></div>
        <div id="clock"></div>
    </div>
        <div class="wrap_text">
            <span><?= $year ?> , <?= date('F', mktime(0, 0, 0, $month)) ?></span>
        </div>

    <div class="container">
        <div class="calendar">
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
$holiday = ["0101" => "元旦", "0214" => "西洋情人節", "0228" => "和平紀念日", "0308" => "婦女節", "0312" => "植樹節", "0314" => "白色情人節", "0329" => "青年節", "0412" => "復活節", "0422" => "世界地球日", "0501" => "勞動節", "0512" => "國際護士節", "0715" => "解嚴紀念日", "0808" => "父親節", "0814" => "空軍節", "0903" => "軍人節", "0928" => "教師節", "1010" => "國慶日", "1024" => "臺灣聯國日", "1025" => "光復節", "1031" => "萬聖節", "1112" => "國父誕辰", "1225" => "行憲紀念日", "1225" => "聖誕節"];
$is_this_month = ($year == $this_year && $month == $this_month);

for ($i = 0; $i < 6; $i++) {
    echo "<tr>";
    for ($j = 0; $j < 7; $j++) {
        echo "<td>";
        if ($i != 0 || $j >= $firstday) {
            $day = $i * 7 + $j + 1  - $firstday;
            if ($day <= $lastday) {
                if ($is_this_month && ($day == $this_day)) {
                    echo "<span class='today'>" . $day . "</span>";
                } else {
                    echo $day;
                }
                $arr=[];
                $holiday_key = sprintf("%02d%02d",$month,$day);
                if(array_key_exists($holiday_key, $holiday)){
                    $arr[]=$holiday[$holiday_key];
                }
                if ($month == 5 && $j == 0 && $day >= 8 && $day <= 14) {
                    $arr[]="母親節";
                }
                if($arr){
                    echo  "<span class='holiday'>" . array_shift($arr);
                    foreach($arr as $value){
                        echo "<br>".$value;
                    }
                    echo  "</span>";
                }
            }
        }
        echo "</td>";
    }
    echo "</tr>";
}
echo "</table>";

?>
                <div class="btn">
                    <a class="lastM" href="index.php?year=<?= $ylast ?>&month=<?= $mlast ?>">Prev</a>
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
                <a class="nextM" href="index.php?year=<?= $ynext ?>&month=<?= $mnext ?>">Next</a>
                <a class="thisM" href="index.php">本月</a>
        </div>
    </div>
    </div>
    <div class="wrap_bg">
        <img src="https://i.imgur.com/IlRhXr5.gif" alt="bg2">
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