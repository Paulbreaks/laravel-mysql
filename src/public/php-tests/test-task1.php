<?php

/**
 * Задание 1:
 *
 * Есть массив данных, нужно написать PHP функцию process_strings(); которая выдаст ожидаемый результат.
 *
 */
function process_strings($arr)
{
    $vowels = array('a', 'e', 'i', 'o', 'u'); // гласные буквы
    $result = array();

    // вынимаем слова из массива
    for ($i = 0; $i < count($arr); $i++) {
        $word = $arr[$i];
        $new_word = ""; // для нового слово

        // Заменим гласные
        for ($j = 0; $j < strlen($word); $j++) {
            if (in_array($word[$j], $vowels)) {
                $new_word .= "*"; // гласную заменяем на *
            } else {
                $new_word .= $word[$j]; // если согл. ост как есть
            }
        }

        // переворачиваем слово
        $reversed_word = "";
        for ($k = strlen($new_word) - 1; $k >= 0; $k--) {
            $reversed_word .= $new_word[$k];
        }

        // сохраняем результат в массив
        $result[] = $reversed_word;
    }

    return $result;
}

// тестируем
$input = array("apple", "banana", "cherry");
$result = process_strings($input);
echo '["' . implode('", "', $result) . '"]'; // Ожидаемый результат: ["*lpp*", "*n*n*b", "yrr*hc"]