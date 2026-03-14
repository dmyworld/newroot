<?php
$file = 'c:/Users/user/Documents/GitHub/www/newroot/application/views/hub/landing.php';
$content = file_get_contents($file);

// 1. Add English Translation Keys
$en_keys = "
        'nav_signin' => 'Sign in',
        'nav_start_free' => 'Start free in 2 minutes',
        'nav_marketplace' => 'Marketplace',
        'nav_green' => 'Green Sri Lanka',
        'footer_mission' => 'Our mission is to digitize the timber industry while preserving Sri Lanka\'s greenery. Every invoice helps plant a future.',
        'footer_ecosystem' => 'Ecosystem',
        'footer_links' => 'Platform',
        'footer_contact' => 'Contact',
";

if (strpos($content, "'nav_signin'") === false) {
    $anchor = "'ready_desc' => 'Join hundreds of Sri Lankan businesses that have transformed their operations with TimberPro.',";
    $content = str_replace($anchor, $anchor . $en_keys, $content);
}

// 2. Add Sinhala Translation Keys
$si_keys = "
        'nav_signin' => 'Sign in',
        'nav_start_free' => '2-min වලින් ලියාපදිංචි වන්න',
        'nav_marketplace' => 'Marketplace',
        'nav_green' => 'Green Sri Lanka',
        'footer_mission' => 'අපගේ අරමුණ ශ්‍රී ලංකාවේ හරිත බව රැකගනිමින් දැව කර්මාන්තය ඩිජිටල්කරණය කිරීමයි. සෑම රිසිට්පතක්ම නව වනාන්තරයක් බිහිකිරීමට උපකාරී වේ.',
        'footer_ecosystem' => 'Ecosystem',
        'footer_links' => 'Platform',
        'footer_contact' => 'Contact',
";

if (strpos($content, "'සිංහල ලියාපදිංචිය'") !== false && strpos($content, "'nav_signin' => 'Sign in'", strpos($content, "'සිංහල ලියාපදිංචිය'")) === false) {
    $anchor = "'ready_desc' => 'TimberPro සමඟ තම ව්‍යාපාරය දියුණු කරගත් සිය ගණනක් ශ්‍රී ලාංකික ව්‍යාපාරිකයන් සමඟ එක්වන්න.',";
    $content = str_replace($anchor, $anchor . $si_keys, $content);
}

// 3. Add Tamil Translation Keys
$ta_keys = "
        'nav_signin' => 'உள்நுழைய',
        'nav_start_free' => '2 நிமிடங்களில் இலவசமாகத் தொடங்குங்கள்',
        'nav_marketplace' => 'சந்தை',
        'nav_green' => 'Green Sri Lanka',
        'footer_mission' => 'எங்கள் நோக்கம் மரத் தொழிலை டிஜිටல் மயமாக்குவதோடு இலங்கையின் பசுமையைப் பாதுகாப்பதாகும். ஒவ்வொரு ரசீதும் காடுகளை வளர்க்க உதவுகிறது.',
        'footer_ecosystem' => 'சுற்றுச்சூழல்',
        'footer_links' => 'மேடை',
        'footer_contact' => 'தொடர்பு',
";

if (strpos($content, "'பயன்படுத்த") !== false && strpos($content, "'nav_signin' => 'உள்நுழைய'") === false) {
    $anchor = "'ready_desc' => 'TimberPro மூலம் தங்கள் வணிகத்தை மேம்படுத்திய நூற்றுக்கணக்கான இலங்கை வணிகர்களுடன் இணையுங்கள்.',";
    $content = str_replace($anchor, $anchor . $ta_keys, $content);
}

file_put_contents($file, $content);
echo "Translations updated.\n";
?>
