<?php
if (!function_exists('_create_name_file')) {
    function _create_name_file($string)
    {
        $file_parts = pathinfo($string);
        $exts = $file_parts['extension'];
        $date = 'file-' . date('Y-m-d') . '-at-' . date('H-i-s') . '-' . rand(1000000, 9999999);

        //var_dump($exts);die;

        $replace = '-';
        if ($exts == 'jpg') {
            $string = str_replace(".jpg", "", $string);
            $ext = '.jpg';
        } elseif ($exts == 'JPG') {
            $string = str_replace(".JPG", "", $string);
            $ext = '.jpg';
        } elseif ($exts == 'png') {
            $string = str_replace(".png", "", $string);
            $ext = '.png';
        } elseif ($exts == 'PNG') {
            $string = str_replace(".PNG", "", $string);
            $ext = '.png';
        } elseif ($exts == 'jpeg') {
            $string = str_replace(".jpeg", "", $string);
            $ext = '.jpg';
        } elseif ($exts == 'JPEG') {
            $string = str_replace(".JPEG", "", $string);
            $ext = '.jpg';
        } elseif ($exts == 'gif') {
            $string = str_replace(".gif", "", $string);
            $ext = '.gif';
        } elseif ($exts == 'pdf') {
            $string = str_replace(".pdf", "", $string);
            $ext = '.pdf';
        } elseif ($exts == 'PDF') {
            $string = str_replace(".PDF", "", $string);
            $ext = '.pdf';
        } else {
            $ext = '.txt';
        }
        $string = strtolower($string);
        //replace / and . with white space     
        $string = preg_replace("/[\/\.]/", " ", $string);
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //remove multiple dashes or whitespaces     
        $string = preg_replace("/[\s-]+/", " ", $string);
        //convert whitespaces and underscore to $replace     
        $string = preg_replace("/[\s_]/", $replace, $string);
        //limit the slug size     
        $string = substr($string, 0, 100);
        //text is generated     
        return ($ext) ? $date . $ext : $date . $ext;
    }
}

if (!function_exists('_create_name_file_import_pegawai')) {
    function _create_name_file_import_pegawai($string)
    {
        $file_parts = pathinfo($string);
        $exts = $file_parts['extension'];

        $filenames = explode(" ", $string);

        $date = 'file-' . $filenames[1] . '-' . date('Y-m-d') . '-at-' . date('H-i-s') . '-' . rand(1000000, 9999999);

        //var_dump($exts);die;

        $replace = '-';
        if ($exts == 'xls') {
            $string = str_replace(".xls", "", $string);
            $ext = '.xls';
        } elseif ($exts == 'XLS') {
            $string = str_replace(".XLS", "", $string);
            $ext = '.xls';
        } elseif ($exts == 'xlsx') {
            $string = str_replace(".xlsx", "", $string);
            $ext = '.xlsx';
        } elseif ($exts == 'XLSX') {
            $string = str_replace(".XLSX", "", $string);
            $ext = '.xlsx';
        } else {
            $ext = '.txt';
        }
        $string = strtolower($string);
        //replace / and . with white space     
        $string = preg_replace("/[\/\.]/", " ", $string);
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //remove multiple dashes or whitespaces     
        $string = preg_replace("/[\s-]+/", " ", $string);
        //convert whitespaces and underscore to $replace     
        $string = preg_replace("/[\s_]/", $replace, $string);
        //limit the slug size     
        $string = substr($string, 0, 100);
        //text is generated     
        return ($ext) ? $date . $ext : $date . $ext;
    }
}

if (!function_exists('_create_name_file_import_tagihan')) {
    function _create_name_file_import_tagihan($string, $foldername = "")
    {
        $file_parts = pathinfo($string);
        $exts = $file_parts['extension'];

        // $filenames = explode(" ", $string);

        $date = 'file-' . $foldername . '-' . date('Y-m-d') . '-at-' . date('H-i-s') . '-' . rand(1000000, 9999999);

        //var_dump($exts);die;

        $replace = '-';
        if ($exts == 'xls') {
            $string = str_replace(".xls", "", $string);
            $ext = '.xls';
        } elseif ($exts == 'XLS') {
            $string = str_replace(".XLS", "", $string);
            $ext = '.xls';
        } elseif ($exts == 'xlsx') {
            $string = str_replace(".xlsx", "", $string);
            $ext = '.xlsx';
        } elseif ($exts == 'XLSX') {
            $string = str_replace(".XLSX", "", $string);
            $ext = '.xlsx';
        } else {
            $ext = '.txt';
        }
        $string = strtolower($string);
        //replace / and . with white space     
        $string = preg_replace("/[\/\.]/", " ", $string);
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //remove multiple dashes or whitespaces     
        $string = preg_replace("/[\s-]+/", " ", $string);
        //convert whitespaces and underscore to $replace     
        $string = preg_replace("/[\s_]/", $replace, $string);
        //limit the slug size     
        $string = substr($string, 0, 100);
        //text is generated     
        return ($ext) ? $date . $ext : $date . $ext;
    }
}

if (!function_exists('_create_name_file_import')) {
    function _create_name_file_import($string)
    {
        $file_parts = pathinfo($string);
        $exts = $file_parts['extension'];

        // $filenames = explode(" ", $string);

        $date = 'file-' . date('Y-m-d') . '-at-' . date('H-i-s') . '-' . rand(1000000, 9999999);

        //var_dump($exts);die;

        $replace = '-';
        if ($exts == 'xls') {
            $string = str_replace(".xls", "", $string);
            $ext = '.xls';
        } elseif ($exts == 'XLS') {
            $string = str_replace(".XLS", "", $string);
            $ext = '.xls';
        } elseif ($exts == 'xlsx') {
            $string = str_replace(".xlsx", "", $string);
            $ext = '.xlsx';
        } elseif ($exts == 'XLSX') {
            $string = str_replace(".XLSX", "", $string);
            $ext = '.xlsx';
        } else {
            $ext = '.txt';
        }
        $string = strtolower($string);
        //replace / and . with white space     
        $string = preg_replace("/[\/\.]/", " ", $string);
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //remove multiple dashes or whitespaces     
        $string = preg_replace("/[\s-]+/", " ", $string);
        //convert whitespaces and underscore to $replace     
        $string = preg_replace("/[\s_]/", $replace, $string);
        //limit the slug size     
        $string = substr($string, 0, 100);
        //text is generated     
        return ($ext) ? $date . $ext : $date . $ext;
    }
}

if (!function_exists('_create_name_file_spj')) {
    function _create_name_file_spj($string, $jenis)
    {
        $file_parts = pathinfo($string);
        $exts = $file_parts['extension'];
        $date = 'file-' . $jenis . '-' . date('Y-m-d') . '-at-' . date('H-i-s') . '-' . rand(1000000, 9999999);

        //var_dump($exts);die;

        $replace = '-';
        if ($exts == 'jpg') {
            $string = str_replace(".jpg", "", $string);
            $ext = '.jpg';
        } elseif ($exts == 'JPG') {
            $string = str_replace(".JPG", "", $string);
            $ext = '.jpg';
        } elseif ($exts == 'png') {
            $string = str_replace(".png", "", $string);
            $ext = '.png';
        } elseif ($exts == 'PNG') {
            $string = str_replace(".PNG", "", $string);
            $ext = '.png';
        } elseif ($exts == 'jpeg') {
            $string = str_replace(".jpeg", "", $string);
            $ext = '.jpg';
        } elseif ($exts == 'JPEG') {
            $string = str_replace(".JPEG", "", $string);
            $ext = '.jpg';
        } elseif ($exts == 'gif') {
            $string = str_replace(".gif", "", $string);
            $ext = '.gif';
        } elseif ($exts == 'pdf') {
            $string = str_replace(".pdf", "", $string);
            $ext = '.pdf';
        } elseif ($exts == 'PDF') {
            $string = str_replace(".PDF", "", $string);
            $ext = '.pdf';
        } else {
            $ext = '.txt';
        }
        $string = strtolower($string);
        //replace / and . with white space     
        $string = preg_replace("/[\/\.]/", " ", $string);
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //remove multiple dashes or whitespaces     
        $string = preg_replace("/[\s-]+/", " ", $string);
        //convert whitespaces and underscore to $replace     
        $string = preg_replace("/[\s_]/", $replace, $string);
        //limit the slug size     
        $string = substr($string, 0, 100);
        //text is generated     
        return ($ext) ? $date . $ext : $date . $ext;
    }
}

if (!function_exists('_create_name_foto')) {
    function _create_name_foto($string)
    {
        $file_parts = pathinfo($string);
        $exts = $file_parts['extension'];
        $date = 'file-' . date('Y-m-d') . '-at-' . date('H-i-s') . '-' . rand(1000000, 9999999);

        //var_dump($exts);die;

        $replace = '-';
        if ($exts == 'jpg') {
            $string = str_replace(".jpg", "", $string);
            $ext = '.jpg';
        } elseif ($exts == 'png') {
            $string = str_replace(".png", "", $string);
            $ext = '.png';
        } elseif ($exts == 'jpeg') {
            $string = str_replace(".jpeg", "", $string);
            $ext = '.jpg';
        } elseif ($exts == 'gif') {
            $string = str_replace(".gif", "", $string);
            $ext = '.gif';
        } elseif ($exts == 'pdf') {
            $string = str_replace(".pdf", "", $string);
            $ext = '.pdf';
        } else {
            $ext = '.txt';
        }
        $string = strtolower($string);
        //replace / and . with white space     
        $string = preg_replace("/[\/\.]/", " ", $string);
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //remove multiple dashes or whitespaces     
        $string = preg_replace("/[\s-]+/", " ", $string);
        //convert whitespaces and underscore to $replace     
        $string = preg_replace("/[\s_]/", $replace, $string);
        //limit the slug size     
        $string = substr($string, 0, 100);
        //text is generated     
        return ($ext) ? $date . $ext : $date . $ext;
    }
}

if (!function_exists('searchFromArray')) {
    function searchFromArray($array, $key, $value)
    {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value)
                $results[] = $array;

            foreach ($array as $subarray)
                $results = array_merge($results, searchFromArray($subarray, $key, $value));
        }

        return $results;
    }
}

function generateSlug($text, $maxLength = 150)
{
    $result = strtolower($text);
    $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
    $result = trim(preg_replace("/[\s-]+/", " ", $result));
    $result = trim(substr($result, 0, $maxLength));
    $result = preg_replace("/\s/", "-", $result);

    return $result;
}
