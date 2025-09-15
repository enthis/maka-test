<?php
for ($i = 1; $i <= 100; $i++) {
    if ($i % 15 == 0) {
        echo 'Mari Berkarya,</br>';
    } elseif ($i % 3 == 0) {
        echo 'Mari,';
    } elseif ($i % 5 == 0) {
        echo 'Berkarya,';
    } else {
        echo $i . ',';
    }
}
