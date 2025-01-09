<?php
require_once('db_lib.php');

class UPLOAD_FILE_DB
{
    public function putfile($filepath,$mime_type,$file_size) {

        $db = new Database();
        $sql = "INSERT INTO images(filepath, mime_type, file_size) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssi", $filepath, $mime_type, $file_size);
            $stmt->execute();
            // echo "New record inserted successfully.";
            $stmt->close();
        }
        $db->close();
    }
}
