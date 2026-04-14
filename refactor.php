<?php
$files = [
    'setup.php',
    'api/db.php',
    'api/place_order.php',
    'admin/index.php',
    'admin/dashboard.php',
    'components/header.html',
    'components/footer.html',
    'index.html',
    'about.html',
    'varieties.html',
    'order.html',
    'process.html',
    'nutrition.html',
    'contact.html',
    'track.html'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    
    $content = file_get_contents($file);
    
    // Branding text
    $content = str_replace('KISANTH', 'Farvine', $content);
    $content = str_replace('kisanth_db', 'farvine_db', $content);
    $content = str_replace('kisanth', 'farvine', $content);
    $content = str_replace('KIS-', 'FRV-', $content);
    
    // Update Tailwind configuration block colors
    $content = str_replace('mango: { 50', 'farvine: { 50', $content);
    $content = str_replace('mango: { 500', 'farvine: { 500', $content);

    // Swap the golden color hexes to the new Farvine Green
    // Standard Palette
    $content = str_replace(
        "{ 50: '#fffbeb', 100: '#fef3c7', 200: '#fde68a', 300: '#fcd34d', 400: '#fbbf24', 500: '#f59e0b', 600: '#d97706', 700: '#b45309', 800: '#92400e', 900: '#78350f' }",
        "{ 50: '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0', 300: '#86efac', 400: '#4ade80', 500: '#22c55e', 600: '#16a34a', 700: '#15803d', 800: '#166534', 900: '#14532d' }", 
        $content
    );
    // Admin index Palette
    $content = str_replace(
        "{ 500: '#f59e0b', 600: '#d97706' }",
        "{ 500: '#22c55e', 600: '#16a34a' }",
        $content
    );
    // Admin dashboard Palette
    $content = str_replace(
        "{ 50: '#fffbeb', 100: '#fef3c7', 500: '#f59e0b', 600: '#d97706', 700: '#b45309' }",
        "{ 50: '#f0fdf4', 100: '#dcfce7', 500: '#22c55e', 600: '#16a34a', 700: '#15803d' }",
        $content
    );

    // Class name swap
    $content = str_replace('mango-', 'farvine-', $content);
    
    file_put_contents($file, $content);
}

echo "REFACTOR_COMPLETE";
?>
