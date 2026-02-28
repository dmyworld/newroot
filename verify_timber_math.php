<?php
/**
 * Timber Calculator Verification Script
 * Validates Hoppus Rule and Cubic Feet formulas against industry standards.
 */

function verify_hoppus($girth, $length, $expected) {
    // Formula: (Girth/4)^2 * Length / 144 (if girth in inches, length in ft)
    // Or if all in feet: (G/4)^2 * L
    $quarter_girth = $girth / 4;
    $volume = ($quarter_girth * $quarter_girth) * $length / 144;
    $volume = round($volume, 4);
    
    if (abs($volume - $expected) < 0.001) {
        echo "[PASS] Hoppus: G=$girth, L=$length => Vol=$volume\n";
    } else {
        echo "[FAIL] Hoppus: G=$girth, L=$length => Vol=$volume (Expected $expected)\n";
    }
}

function verify_cubic($w, $t, $l, $q, $expected) {
    // Formula: (W * T * L * Q) / 144
    $volume = ($w * $t * $l * $q) / 144;
    $volume = round($volume, 4);
    
    if (abs($volume - $expected) < 0.001) {
        echo "[PASS] Sawn Cubic: W=$w, T=$t, L=$l, Q=$q => Vol=$volume\n";
    } else {
        echo "[FAIL] Sawn Cubic: W=$w, T=$t, L=$l, Q=$q => Vol=$volume (Expected $expected)\n";
    }
}

echo "Starting Timber Math Verification...\n";
echo "------------------------------------\n";

// Test 1: Log with 40 inch girth, 10 ft length
// (40/4)^2 * 10 / 144 = 100 * 10 / 144 = 1000 / 144 = 6.9444
verify_hoppus(40, 10, 6.9444);

// Test 2: Sawn timber 2x4x10 ft, 12 pieces
// (2 * 4 * 10 * 12) / 144 = 960 / 144 = 6.6667
verify_cubic(2, 4, 10, 12, 6.6667);

// Test 3: Sawn timber 1x6x12 ft, 50 pieces
// (1 * 6 * 12 * 50) / 144 = 3600 / 144 = 25
verify_cubic(1, 6, 12, 50, 25);

echo "------------------------------------\n";
echo "Verification Complete.\n";
