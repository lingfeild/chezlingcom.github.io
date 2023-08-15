<?php
function verify_file_extensions($files)
{
    $allowed = array('gif', 'png', 'jpg', 'jpeg');

    for ($i = 1; $i < 7; $i++) {
        if (array_key_exists('uploaded_file' . $i, $files) && $files['uploaded_file' . $i]['name'] != "") {
            $filename = $files['uploaded_file' . $i]['name'];
            $filename = strtolower($filename);
            $ext      = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                return false;
            }
        }
    }
    return true;
}

function verify_files_not_empty($user_data, $files, $is_new_user)
{
    if ($is_new_user) {
        if ($user_data['tier_choice'] == 1) {
            if ($files['uploaded_file1']['name'] == "") {
                return false;
            }
        }
        if ($user_data['tier_choice'] == 2) {
            if ($files['uploaded_file2']['name'] == "" || $files['uploaded_file3']['name'] == "") {
                return false;
            }
        }
        if ($user_data['tier_choice'] == 3) {
            if ($files['uploaded_file4']['name'] == "" || $files['uploaded_file5']['name'] == "" || $files['uploaded_file6']['name'] == "") {
                return false;
            }
        }
    } else {
        if ($user_data['tier_choice'] == 2) {
            if ($files['uploaded_file3']['name'] == "") {
                return false;
            }
        }
        if ($user_data['tier_choice'] == 3) {
            if ($files['uploaded_file5']['name'] == "" && $files['uploaded_file6']['name'] == "") {
                return false;
            }
        }
    }
    return true;
}
