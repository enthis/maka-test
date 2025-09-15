<?php
for ($i = 0; $i <= 10; $i++) {
    for ($k = 0; $k < 10 - $i; $k++) {
        echo "*&nbsp;";
    }

    echo "</br>";
    for ($k2 = 0; $k2 < 11 - $k; $k2++) {
        echo "&nbsp;";
    }
}
