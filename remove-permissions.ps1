# Script to remove getUserPermissions calls from all PHP files
$files = Get-ChildItem -Path "Modules" -Recurse -Filter "*.php" | Where-Object { 
    (Get-Content $_.FullName -Raw) -match "getUserPermissions"
}

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    $originalContent = $content
    
    # Remove lines containing getUserPermissions
    $lines = Get-Content $file.FullName
    $newLines = $lines | Where-Object { $_ -notmatch "getUserPermissions" }
    
    # Remove $role from compact() calls
    $newContent = $newLines -join "`n"
    $newContent = $newContent -replace "compact\(([^)]*),?\s*['\`"]role['\`"]\s*,?([^)]*)\)", 'compact($1$2)'
    $newContent = $newContent -replace "compact\(['\`"]role['\`"]\s*,?\s*([^)]*)\)", 'compact($1)'
    $newContent = $newContent -replace "compact\(([^)]*),?\s*['\`"]role['\`"]\s*\)", 'compact($1)'
    
    if ($newContent -ne $originalContent) {
        Set-Content -Path $file.FullName -Value $newContent -NoNewline
        Write-Host "Processed: $($file.FullName)"
    }
}

Write-Host "Done processing $($files.Count) files"
