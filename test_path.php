<?php
$FM_ROOT_PATH = array(
    0 => '/var/www/documents',
    1 => '/var/www/html/custom'
);

function fm_get_path($fragment) {
    global $FM_ROOT_PATH;
    if (is_array($FM_ROOT_PATH)) {
        $parts = explode('/', $fragment, 2);
        $idx = $parts[0];
        echo "Fragment: $fragment\n";
        echo "Extracted Index Key: '$idx'\n";
        if (isset($FM_ROOT_PATH[$idx])) {
            echo "Found! Path: " . $FM_ROOT_PATH[$idx] . "\n";
            return $FM_ROOT_PATH[$idx];
        } else {
            echo "Not Found in FM_ROOT_PATH keys: " . implode(', ', array_keys($FM_ROOT_PATH)) . "\n";
        }
        
        // Proposed Fix Logic
        $sep_pos = strpos($idx, '-');
        if ($sep_pos !== false) {
            $real_idx = substr($idx, 0, $sep_pos);
            echo "Parsed Index: '$real_idx'\n";
            if (isset($FM_ROOT_PATH[$real_idx])) {
                 echo "Fix Found! Path: " . $FM_ROOT_PATH[$real_idx] . "\n";
            }
        }
        
        return false;
    }
    return $FM_ROOT_PATH;
}

fm_get_path('0-documents');
fm_get_path('1-custom/subfolder');
