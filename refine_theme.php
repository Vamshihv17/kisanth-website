<?php
$files = [
    'index.html',
    'about.html',
    'varieties.html',
    'order.html',
    'process.html',
    'nutrition.html',
    'contact.html',
    'track.html',
    'components/header.html',
    'components/footer.html'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // Changing gradient artifacts from the orange theme to the green theme
    $content = str_replace('from-orange-50/50', 'from-green-50/50', $content);
    $content = str_replace('bg-yellow-300 rounded-full mix-blend-multiply', 'bg-lime-300 rounded-full mix-blend-multiply', $content);
    $content = str_replace('border-amber-500', 'border-emerald-500', $content);
    $content = str_replace('bg-amber-600 rounded-full mix-blend-screen', 'bg-emerald-600 rounded-full mix-blend-screen', $content);
    $content = str_replace('from-amber-100', 'from-green-100', $content);
    
    // Ticker emoji change
    $content = str_replace('🥭', '🌿', $content);
    
    // Product terminology change to align with "As fresh as it grows"
    $content = str_replace('Premium Farm Fresh Mangoes', 'Premium Farm Fresh Produce', $content);

    // Optional: Only changing text explicitly referring to 'mangoes' if it feels out of place with the new brand
    // Since we still have Alphonso imagery and DB varieties, I will preserve 'mango' text in most places, 
    // unless it's in the footer global tagline.
    if ($file === 'components/footer.html') {
        $content = str_replace('naturally grown mangoes', 'naturally grown produce', $content);
    }
    
    if ($file === 'index.html') {
        $content = str_replace('king of mangoes', 'king of fruits', $content);
        $content = str_replace('mango variety offers', 'variety offers', $content);
    }

    file_put_contents($file, $content);
}

echo "REFINE_COMPLETE";
?>
