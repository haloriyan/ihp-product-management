<?php

function initial($name) {
    $names = explode(" ", $name);
    $toReturn = $names[0][0];
    if (count($names) > 1) {
        $toReturn .= $names[count($names) - 1][0];
    }

    return strtoupper($toReturn);
}

function Substring($text, $count) {
    $toReturn = substr($text, 0, $count);
    $rest = explode($toReturn, $text);
    if ($rest[1] != "") {
        $toReturn .= "...";
    }
    return $toReturn;
}

function currency_encode($angka, $currencyPrefix = 'Rp', $thousandSeparator = '.', $zeroLabel = 'Gratis') {
	if (!$angka) {
		return "Rp 0";
	}
    return $currencyPrefix.' '.strrev(implode($thousandSeparator,str_split(strrev(strval($angka)),3)));
}
function currency_decode($rupiah) {
    return intval(preg_replace("/,.*|[^0-9]/", '', $rupiah));
}