<?php

class TemplateTag {

    public static function fmt_num($num) {
	    return number_format($num, 0, ',', '.');
    }
}

function fmtnum($num) {
	return number_format($num, 0, ',', '.');
}

