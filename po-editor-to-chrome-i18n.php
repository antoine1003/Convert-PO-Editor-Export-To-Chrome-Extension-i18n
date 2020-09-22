<?php
include_once 'Console.php';

const ARG_REGEX = '/\$(([a-z]+)|([A-Z]+))\$/';
const DEFAULT_OUTPUT_FOLDER = 'output/';
const DEFAULT_DATA_FOLDER = 'data/';

if (count($argv) == 2 && !in_array('-h', $argv)) {
    $filePath = $argv[1];
    if (file_exists($filePath)) {
        $jsonStr = file_get_contents($filePath);
        if (isJson($jsonStr)) {
            $jsonArray = json_decode($jsonStr);
            $filnameNoExtension = basename($filePath, ".json");
            foreach ($jsonArray as $key => $value) {                
                $obj[$key]['message'] = $value;
                preg_match_all(ARG_REGEX, $value, $matches, PREG_SET_ORDER);
                if ($matches != null && count($matches) > 0) {
                    for($i = 0; $i < count($matches); $i++) {
                        $varName = $matches[$i][1];
                        $objPlaceholder['content'] = '$'. ($i + 1);
                        $placeholders[$varName] = $objPlaceholder;
                    }
                    $obj[$key]['placeholders'] = $placeholders;
                    $placeholders = [];
                }           
            }  
            $jsonStringOutput = json_encode($obj, JSON_UNESCAPED_UNICODE);
            $exportedFileName = $filnameNoExtension . '_' . date('Y_m_d_h_i') . '.json';
            file_put_contents(DEFAULT_OUTPUT_FOLDER . DIRECTORY_SEPARATOR . $exportedFileName, $jsonStringOutput);
        } else {
            logError('File content seems not to be valid JSON.');
        }
    } else {
        logError('File do not exist.');
    }
} else {
    logInfo('Usage php ./po-editor-to-chrome-i18n.php path/to/json/file.json');
    logInfo('JSON must be exported by PO Editor in key => value format.');
}


/**
 * Check if the given string is a valid JSON
 */
function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

function logError($message) {
    echo Console::red("[ERROR] $message" . PHP_EOL);
}

function logInfo($message) {
    echo Console::blue("[INFO] $message" . PHP_EOL);
}

function logSuccess($message) {
    echo Console::green("[SUCCESS] $message" . PHP_EOL);
}