<?php
$file = 'c:/Users/user/Documents/GitHub/www/newroot/application/views/hub/landing.php';
$content = file_get_contents($file);

// 1. Replace Header HTML (Premium Redesign)
$header_html = '
    <header class="header-nav">
        <div class="nav-inner">
            <a href="<?php echo base_url(); ?>" class="brand">
                <div class="brand-logo">T</div>
                <span>TimberPro</span>
            </a>

            <div class="nav-links">
                <a href="#features" class="nav-link">Features</a>
                <a href="<?php echo base_url(\'shop\'); ?>" class="nav-link"><?php echo $t[\'nav_marketplace\']; ?></a>
                <a href="<?php echo base_url(\'greenfuture\'); ?>" class="nav-link"><?php echo $t[\'nav_green\']; ?></a>
                <a href="#pricing" class="nav-link">Pricing</a>
            </div>

            <div class="nav-actions">
                <div class="lang-switcher">
                    <a href="?lang=en" class="lang-btn <?php echo $lang_id == \'en\' ? \'active\' : \'\'; ?>">EN</a>
                    <a href="?lang=si" class="lang-btn <?php echo $lang_id == \'si\' ? \'active\' : \'\'; ?>">සිං</a>
                    <a href="?lang=ta" class="lang-btn <?php echo $lang_id == \'ta\' ? \'active\' : \'\'; ?>">தழ்</a>
                </div>
                <a href="<?php echo base_url(\'hub/login\'); ?>" class="nav-link" style="color:var(--text)"><?php echo $t[\'nav_signin\']; ?></a>
                <a href="#register" class="btn-primary" style="padding: 0.6rem 1.2rem; font-size: 0.8rem; box-shadow: 0 4px 12px var(--accent-soft);">
                    <?php echo $t[\'nav_start_free\']; ?>
                </a>
            </div>
        </div>
    </header>

    <div class="shell" style="padding-top: 4rem;">
';

$header_start = '<header class="nav">';
$header_end = '<!-- Hero -->';

$h_start_pos = strpos($content, $header_start);
$h_end_pos = strpos($content, $header_end, $h_start_pos);

if ($h_start_pos !== false && $h_end_pos !== false) {
    // Also remove the <div class="shell"> that usually wraps the nav in the original
    // Based on view, it was:
    // <div class="shell">
    //    <header class="nav">
    
    // We want to replace from the shell opening if possible, or just replace the header and adjust the shell.
    // Let's find the shell opening just before the header
    $shell_open = '<div class="shell">';
    $shell_pos = strrpos(substr($content, 0, $h_start_pos), $shell_open);
    
    if ($shell_pos !== false && ($h_start_pos - $shell_pos) < 50) {
        $content = substr_replace($content, $header_html, $shell_pos, $h_end_pos - $shell_pos);
    } else {
        $content = substr_replace($content, $header_html, $h_start_pos, $h_end_pos - $h_start_pos);
    }
    
    echo "Header HTML replaced.\n";
} else {
    echo "Could not find Header HTML anchor (Start: " . ($h_start_pos === false ? 'No' : 'Yes') . ", End: " . ($h_end_pos === false ? 'No' : 'Yes') . ").\n";
}

file_put_contents($file, $content);
echo "Final file saved.\n";
?>
