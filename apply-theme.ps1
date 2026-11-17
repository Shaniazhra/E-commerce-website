# apply-theme.ps1
# Run from the Laravel project root (the folder that contains "artisan").

$ErrorActionPreference = 'Stop'

$root  = (Get-Location).Path
$views = Join-Path $root 'resources\views'

if (-not (Test-Path (Join-Path $root 'artisan')))                  { throw 'Run this from the Laravel project root (the folder with artisan).' }
if (-not (Test-Path (Join-Path $root 'resources\css\theme.css')))  { throw 'resources\css\theme.css not found. Copy it there first.' }
if (-not (Test-Path (Join-Path $root 'public\farhana.svg')))       { Write-Warning 'public\farhana.svg not found. The favicon link will point to a missing file.' }

$utf8 = New-Object System.Text.UTF8Encoding($false)
function Read-File($path)         { [System.IO.File]::ReadAllText($path, $utf8) }
function Write-File($path, $text) { [System.IO.File]::WriteAllText($path, $text, $utf8) }

# 1. Backup
$stamp  = Get-Date -Format 'yyyyMMdd-HHmmss'
$backup = Join-Path $root "backup-views-$stamp"
Copy-Item $views $backup -Recurse
$viteCfg = Join-Path $root 'vite.config.js'
if (Test-Path $viteCfg) { Copy-Item $viteCfg (Join-Path $backup 'vite.config.js.bak') }
Write-Host "Backup saved to: $backup" -ForegroundColor Green

# 2. vite.config.js
if (Test-Path $viteCfg) {
    $cfg = Read-File $viteCfg
    if ($cfg -match 'theme\.css') {
        Write-Host 'vite.config.js already includes theme.css' -ForegroundColor DarkGray
    } else {
        $new = [regex]::Replace($cfg, '([''"])resources/css/app\.css\1', '$&, ''resources/css/theme.css''')
        if ($new -ne $cfg) {
            Write-File $viteCfg $new
            Write-Host 'vite.config.js: added resources/css/theme.css' -ForegroundColor Green
        } else {
            Write-Warning "Could not patch vite.config.js. Add 'resources/css/theme.css' to the input array manually."
        }
    }
}

# 3. Pages
$skipFolders = @('\admin\', '\partials\', '\components\', '\emails\', '\vendor\')
$skipFiles   = @('layouts\shop.blade.php', 'layouts\app.blade.php')

$files = Get-ChildItem $views -Recurse -Filter *.blade.php | Where-Object {
    $rel = $_.FullName.Substring($views.Length + 1)
    $keep = $true
    foreach ($s in $skipFolders) { if ($_.FullName -like "*$s*") { $keep = $false } }
    if ($skipFiles -contains $rel) { $keep = $false }
    $keep
}

$report = @()

foreach ($f in $files) {
    $rel   = $f.FullName.Substring($views.Length + 1)
    $text  = Read-File $f.FullName
    $fixed = @()

    if ($text -match '<html') {

        if ($text -notmatch 'farhana\.svg') {
            $link = "    <link rel=""icon"" type=""image/svg+xml"" href=""{{ asset('farhana.svg') }}"">`r`n"
            $text = ([regex]'</head>').Replace($text, $link + '</head>', 1)
            $fixed += 'favicon'
        }

        if ($text -match '@vite' -and $text -notmatch 'theme\.css') {
            $text = [regex]::Replace($text, '([''"])resources/css/app\.css\1', '$&, ''resources/css/theme.css''')
            if ($text -match 'theme\.css') { $fixed += 'theme.css' } else { $fixed += 'theme.css (manual)' }
        }

        $m = [regex]::Match($text, '<title>\s*([^<{]*?)\s*</title>')
        if ($m.Success) {
            $title = $m.Groups[1].Value
            $newTitle = $title
            if     ($title -match '^Farhana Web\s*-\s*')           { $newTitle = $title -replace '^Farhana Web\s*-\s*', 'Farhana - ' }
            elseif ($title -notmatch '^Farhana(\s+Web)?\s*(-|$)')  { $newTitle = "Farhana - $title" }
            if ($newTitle -ne $title) {
                $text = $text.Replace($m.Value, "<title>$newTitle</title>")
                $fixed += 'title'
            }
        } elseif ($text -match '<title>') {
            $fixed += 'title (dynamic, manual)'
        }

        if ($fixed.Count -gt 0) { Write-File $f.FullName $text }
    }

    $type = 'standalone html'
    if     ($text -match "@extends\('layouts\.shop'\)") { $type = 'layouts.shop' }
    elseif ($text -match '<x-app-layout')               { $type = 'x-app-layout' }
    elseif ($text -match '<x-guest-layout')             { $type = 'x-guest-layout' }
    elseif ($text -notmatch '<html')                    { $type = 'partial / other' }

    $own = @()
    if ($text -match '<nav|<header') { $own += 'navbar' }
    if ($text -match '<footer')      { $own += 'footer' }

    $report += [pscustomobject]@{
        File          = $rel
        Layout        = $type
        OwnNavFooter  = ($own -join ', ')
        AutoFixed     = ($fixed -join ', ')
    }
}

Write-Host ''
$report | Sort-Object Layout, File | Format-Table -AutoSize

$todo = $report | Where-Object { $_.Layout -in 'standalone html', 'x-guest-layout' -or ($_.OwnNavFooter -and $_.Layout -ne 'layouts.shop') }
Write-Host ''
if ($todo) {
    Write-Host 'Still need converting to layouts.shop (own navbar/footer or separate layout):' -ForegroundColor Yellow
    $todo | ForEach-Object { Write-Host "  - $($_.File)" }
} else {
    Write-Host 'All pages already use the shared layout.' -ForegroundColor Green
}

Write-Host ''
Write-Host 'Next: npm run build ; php artisan view:clear' -ForegroundColor Cyan
