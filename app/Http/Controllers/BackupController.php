<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $backupPath = storage_path('app/backups');
        $backups = [];
        
        if (file_exists($backupPath)) {
            $files = scandir($backupPath, SCANDIR_SORT_DESCENDING);
            
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                    $filepath = $backupPath . '/' . $file;
                    $backups[] = [
                        'name' => $file,
                        'size' => $this->formatBytes(filesize($filepath)),
                        'date' => date('Y-m-d H:i:s', filemtime($filepath))
                    ];
                }
            }
        }
        
        return view('backup.index', compact('backups'));
    }
    
    public function backup()
    {
        try {
            $database = env('DB_DATABASE');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $host = env('DB_HOST');
            
            $timestamp = date('Ymd_Hi');
            $filename = "backup_{$timestamp}.sql";
            $tempPath = sys_get_temp_dir();
            $filepath = $tempPath . '/' . $filename;
            
            // Try to find mysqldump in common locations
            $mysqldumpPaths = [
                'C:\\xampp\\mysql\\bin\\mysqldump.exe',
                'C:\\wamp64\\bin\\mysql\\mysql8.0.27\\bin\\mysqldump.exe',
                'mysqldump', // If it's in PATH
            ];
            
            $mysqldump = null;
            foreach ($mysqldumpPaths as $path) {
                if (file_exists($path) || $path === 'mysqldump') {
                    $mysqldump = $path;
                    break;
                }
            }
            
            if ($mysqldump) {
                // Build mysqldump command for Windows
                $passwordArg = $password ? "--password=" . escapeshellarg($password) : "";
                $command = sprintf(
                    '"%s" --user=%s %s --host=%s %s > "%s" 2>&1',
                    $mysqldump,
                    escapeshellarg($username),
                    $passwordArg,
                    escapeshellarg($host),
                    escapeshellarg($database),
                    $filepath
                );
                
                // Execute the command
                exec($command, $output, $returnVar);
                
                if ($returnVar === 0 && file_exists($filepath) && filesize($filepath) > 0) {
                    return response()->download($filepath, $filename)->deleteFileAfterSend(true);
                }
            }
            
            // Fallback to PHP-based backup
            return $this->phpBackup();
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function download($filename)
    {
        $backupPath = storage_path('app/backups');
        $filepath = $backupPath . '/' . $filename;
        
        if (file_exists($filepath)) {
            return response()->download($filepath);
        }
        
        abort(404);
    }
    
    private function phpBackup()
    {
        try {
            $tables = [];
            $result = DB::select('SHOW TABLES');
            
            foreach ($result as $row) {
                $tables[] = array_values((array)$row)[0];
            }
            
            $return = '';
            
            foreach ($tables as $table) {
                $result = DB::select("SELECT * FROM `{$table}`");
                
                $return .= "DROP TABLE IF EXISTS `{$table}`;\n";
                
                $createTable = DB::select("SHOW CREATE TABLE `{$table}`");
                $return .= $createTable[0]->{'Create Table'} . ";\n\n";
                
                foreach ($result as $row) {
                    $values = [];
                    foreach ((array)$row as $value) {
                        if ($value === null) {
                            $values[] = 'NULL';
                        } else {
                            $values[] = '"' . addslashes($value) . '"';
                        }
                    }
                    $return .= "INSERT INTO `{$table}` VALUES (" . implode(',', $values) . ");\n";
                }
                
                $return .= "\n\n";
            }
            
            $timestamp = date('Ymd_Hi');
            $filename = "backup_{$timestamp}.sql";
            
            // Return as download directly
            return response()->streamDownload(function() use ($return) {
                echo $return;
            }, $filename, [
                'Content-Type' => 'application/sql',
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
