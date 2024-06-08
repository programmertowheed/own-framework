<?php

/**
 * @param $message
 * @param array $data
 * @return \Illuminate\Http\JsonResponse
 */
if (!function_exists('sendResponse')) {
    function sendResponse($message = '', $data = [], $code = 200)
    {
        $response = [
            'status' => true,
            'message' => $message
        ];

        !empty($data) ? $response['data'] = $data : null;

        return response()->json($response, $code);
    }
}


/**
 * @param $message
 * @param array $messages
 * @param int $code
 * @return \Illuminate\Http\JsonResponse
 */
if (!function_exists('sendError')) {
    function sendError($message = '', $errors = [], $code = 404)
    {
        $response = [
            'status' => false,
            'message' => $message
        ];

        !empty($errors) ? $response['errors'] = $errors : null;

        return response()->error($response, $code);
    }
}


/**
 * server error response function
 *
 * @return \Illuminate\Http\JsonResponse
 */
if (!function_exists('serverError')) {
    function serverError()
    {
        return response()->serverError();
    }
}


/**
 * Generate random number function
 *
 * @param integer $length
 * @return void
 */
if (!function_exists('randomString')) {
    function randomString($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
}

if (!function_exists('fileUpload')) {
    function fileUpload($data, $dataname, $folder)
    {
        $folder = ltrim($folder, "/");
        $folder = rtrim($folder, "/");

        $file_name = $data[$dataname]['name'];
        $file_temp = $data[$dataname]['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = md5(randomString("8")) . '.' . $file_ext;
        $upload_path = root_path() . "/" . $folder . "/" . $unique_image;

        $returnImage = $folder . "/" . $unique_image;

        if (!empty($file_name)) {
            move_uploaded_file($file_temp, $upload_path);
            return $returnImage;
        }
        return false;
    }
}

/**
 * delete file
 *
 * @param $path
 */
if (!function_exists('deleteFile')) {
    function deleteFile($path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }
}


if (!function_exists('fileUpdate')) {
    function fileUpdate($data, $dataname, $folder, $oldFile)
    {
        if ($oldFile != "") {
            $path = root_path() . "/" . $oldFile;
            deleteFile($path);
        }
        return fileUpload($data, $dataname, $folder);
    }
}


if (!function_exists('base_path')) {
    function base_path()
    {
        return BASE_PATH;
    }
}


if (!function_exists('root_path')) {
    function root_path()
    {
        return __DIR__ . "/../public";
    }
}

if (!function_exists('public_path')) {
    function public_path()
    {
        return BASE_URL . "/public";
    }
}

if (!function_exists('assets')) {
    function assets($path)
    {
        return BASE_URL . "/public/" . $path;
    }
}


if (!function_exists('url')) {
    function url($path)
    {
        return BASE_URL . $path;
    }
}


if (!function_exists('includes')) {
    function includes($filename, $data = [])
    {
        if (!is_array($data)) {
            response()->viewError("404", "Your data should be an array!");
        }
        extract($data);
        $filename = str_replace(".", "/", $filename);
        include BASE_PATH . "app/views/" . $filename . ".php";
    }
}


if (!function_exists('escape_str')) {
    function escape_str($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }
}

if (!function_exists('dateFormatedMY')) {
    function dateFormatedMY($date)
    {
        if ($date == "") {
            return "";
        }
        $newDate = date_create($date);
        return date_format($newDate, "d M Y");
    }
}


if (!function_exists('getParams')) {
    function getParams()
    {
//        ob_start();
//        session_start();
        return isset($_SESSION["route_params"]) ? $_SESSION["route_params"] : "";
    }
}

if (!function_exists('canAccess')) {
    function canAccess($slug)
    {
        $permissions = \App\Models\Permission::getUserAccessPermission();
        if (isset($permissions[$slug])) {
            return true;
        }
        return false;
    }
}


if (!function_exists('route')) {
    function route($path, $params = [])
    {
        $queryString = "";
        if ($params) {
            $numItems = count($params);
            $i = 0;
            $queryString .= "?";
            foreach ($params as $key => $value) {
                if (++$i === $numItems) {
                    $queryString .= $key . "=" . $value;
                } else {
                    $queryString .= $key . "=" . $value . "&";
                }
            }
        }

        $_SESSION["route_params"] = $params;
        $path = ltrim($path, '/');
        return BASE_URL . "/" . $path;
    }
}


// convert number to word
if (!function_exists('convertNumberToWord')) {
    function convertNumberToWord($num = false)
    {
        $num = str_replace(array(',', ' '), '', trim($num));
        if (!$num) {
            return false;
        }
        $num = (int)$num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int)(($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int)($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int)($num_levels[$i] % 100);
            $singles = '';
            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int)($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . (($levels && ( int )($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        $fullString = implode(' ', $words);
        return ucwords($fullString);
    }
}

// convert number to word With Poisha
if (!function_exists('convertNumberToWordWithPoisha')) {
    function convertNumberToWordWithPoisha($number)
    {
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if ($number < 0) {
            return $negative . numberToWords(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', (string)$number);
        }

        $string = convertIntegerPartToWords((int)$number, $dictionary, $hyphen, $conjunction, $separator);

        if ($fraction !== null && is_numeric($fraction)) {
            $string .= $decimal;
            foreach (str_split((string)$fraction) as $number) {
                $string .= ' ' . $dictionary[$number];
            }
        }

        return $string;
    }

}

if (!function_exists("convertIntegerPartToWords")) {
    function convertIntegerPartToWords($number, $dictionary, $hyphen, $conjunction, $separator)
    {
        if ($number < 21) {
            return $dictionary[$number];
        } elseif ($number < 100) {
            $tens = ((int)($number / 10)) * 10;
            $units = $number % 10;
            return $dictionary[$tens] . ($units ? $hyphen . $dictionary[$units] : '');
        } elseif ($number < 1000) {
            $hundreds = (int)($number / 100);
            $remainder = $number % 100;
            return $dictionary[$hundreds] . ' ' . $dictionary[100] . ($remainder ? $conjunction . convertIntegerPartToWords($remainder, $dictionary, $hyphen, $conjunction, $separator) : '');
        } else {
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int)($number / $baseUnit);
            $remainder = $number % $baseUnit;
            return convertIntegerPartToWords($numBaseUnits, $dictionary, $hyphen, $conjunction, $separator) . ' ' . $dictionary[$baseUnit] . ($remainder ? ($remainder < 100 ? $conjunction : $separator) . convertIntegerPartToWords($remainder, $dictionary, $hyphen, $conjunction, $separator) : '');
        }
    }
}


if (!function_exists("getCookie")) {
    function getCookie($name)
    {
        if (isset($_COOKIE[$name])) {
            return json_decode($_COOKIE[$name]);
        } else {
            return false;
        }
    }
}

if (!function_exists("deleteCookie")) {
    function deleteCookie($name)
    {
        if (isset($_COOKIE[$name])) {
            setcookie($name, "", time() - 3600);
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists("redirectTo")) {
    function redirectTo($url, $permanent = false)
    {
        $url = ltrim($url, "/");
        header('Location: ' . url("/$url"), true, $permanent ? 301 : 302);
        exit();
    }
}

if (!function_exists("generateID")) {
    function generateID($priFix, $maxId, $len)
    {
        $nextIdNum = trim($maxId, $priFix) + 1;
        $padlen = $len - (strlen($priFix) + strlen($nextIdNum)) + 1;
        $nextID = str_pad($priFix, $padlen, "0") . $nextIdNum;
        if (strlen($nextID) <= $len) {
            return $nextID;
        } else {
            return "ID over flow !!!";
        }
    }
}

