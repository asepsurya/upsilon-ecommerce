Set-Location 'E:\02.Project\Upsilon Ecommerce'
$files = Get-ChildItem -Recurse -Filter '*.blade.php' -Path 'resources\views' | Select-Object -ExpandProperty FullName
$oldLink = '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">'
$newLink = '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Manrope:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet"/><link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/><link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>'
foreach ($file in $files) {
    $content = Get-Content $file -Raw
    if ($content.Contains('family=Inter')) {
        $content = $content.Replace($oldLink, $newLink)
        $content = $content.Replace("body { font-family: 'Inter', sans-serif; }`n        h1, h2, h3, h4, h5, h6, .font-headline-md { font-family: 'Playfair Display', serif; }", '')
        $content = $content.Replace("body { font-family: 'Inter', sans-serif; }`r`n        h1, h2, h3, h4, h5, h6, .font-headline-md { font-family: 'Playfair Display', serif; }", '')
        $content = $content.Replace("body { font-family: 'Inter', sans-serif; }`n    h1, h2, h3, h4, h5, h6, .font-headline-md { font-family: 'Playfair Display', serif; }", '')
        $content = $content.Replace("body { font-family: 'Inter', sans-serif; }`r`n    h1, h2, h3, h4, h5, h6, .font-headline-md { font-family: 'Playfair Display', serif; }", '')
        Set-Content $file $content
        Write-Host "Replaced fonts: $file"
    }
}
