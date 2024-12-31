<?php

if (isset($_POST['backup'])) {
    // Database configuration
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = 'password';
    $dbName = 'dbname';

    // Create a backup filename with the current date and time
    $backupFileName = $dbName . '_full_backup_' . date('Y-m-d_H-i-s') . '.sql';

    // Full path to mysqldump
    $mysqldumpPath = '"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqldump.exe"';

    // Command to execute the mysqldump for full backup (structure + data)
    $command = "$mysqldumpPath --opt -h$dbHost -u$dbUsername -p$dbPassword $dbName > $backupFileName 2>&1";

    // Execute the command and capture output and return status
    $output = [];
    $returnVar = null;
    exec($command, $output, $returnVar);

    // Log output and return status for debugging
    file_put_contents('backup_log.txt', print_r($output, true));
    file_put_contents('backup_log.txt', "\nReturn Var: " . $returnVar, FILE_APPEND);

    // Check if the backup file was created
    if (file_exists($backupFileName) && filesize($backupFileName) > 0) {
        // Set headers to force download of the backup file
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($backupFileName));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($backupFileName));

        // Clear output buffer
        ob_clean();
        flush();

        // Read the file for download
        readfile($backupFileName);

        // Delete the backup file after download
        unlink($backupFileName);
        exit;
    } else {
        echo "Failed to create backup. Check the backup_log.txt for details.";
    }
} else {
    echo "Invalid request.";
}

?>
