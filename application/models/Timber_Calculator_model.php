<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timber_Calculator_model extends CI_Model
{
    /**
     * Calculate Log Volume using Hoppus Rule
     * Formula: (Girth/4)^2 * Length / 144
     * @param float $girth Girth in inches
     * @param float $length Length in feet
     * @return float Volume in Cubic Feet (ft3)
     */
    public function calculate_hoppus($girth, $length)
    {
        if ($girth <= 0 || $length <= 0) return 0;
        return ($girth / 4) ** 2 * $length / 144;
    }

    /**
     * Calculate Sawn Timber Volume
     * Formula: (Width * Thickness * Length) / 144
     * @param float $width Width in inches
     * @param float $thickness Thickness in inches
     * @param float $length Length in feet
     * @param int $quantity Number of pieces
     * @return float Volume in Cubic Feet (ft3)
     */
    public function calculate_sawn_volume($width, $thickness, $length, $quantity = 1)
    {
        if ($width <= 0 || $thickness <= 0 || $length <= 0 || $quantity <= 0) return 0;
        return ($width * $thickness * $length) / 12 * $quantity / 12; // (W*T*L)/144 simplified as (W*T*L)/144
        // Wait, (Width" * Thickness" * Length') / 12. 
        // 1 cubic foot = 12" x 12" x 1'. 
        // So (Width" * Thickness" * Length') / 144.
    }

    /**
     * Calculate Running Feet
     * @param float $length Length in feet
     * @param int $quantity Number of pieces
     * @return float Total Running Feet
     */
    public function calculate_running_feet($length, $quantity = 1)
    {
        return $length * $quantity;
    }

    /**
     * Calculate Square Feet (Surface Area)
     * @param float $width Width in inches
     * @param float $length Length in feet
     * @param int $quantity Number of pieces
     * @return float Surface Area in Square Feet
     */
    public function calculate_square_feet($width, $length, $quantity = 1)
    {
        return ($width * $length) / 12 * $quantity;
    }

    /**
     * Estimate Price based on volume, species, and unit
     * @param float $volume
     * @param string $species
     * @param string $unit (cubic_ft, sq_ft, running_ft)
     * @return array [estimate, price_per_unit, source]
     */
    public function estimate_market_price($volume, $species = 'default', $unit = 'cubic_ft')
    {
        // Fallback default prices (LKR)
        $defaults = [
            'Teak'     => ['cubic_ft' => 18000, 'sq_ft' => 1500, 'running_ft' => 150],
            'Kos'      => ['cubic_ft' => 9000,  'sq_ft' => 800,  'running_ft' => 80],
            'Mahogany' => ['cubic_ft' => 15000, 'sq_ft' => 1200, 'running_ft' => 120],
            'Nadun'    => ['cubic_ft' => 12000, 'sq_ft' => 1000, 'running_ft' => 100],
            'default'  => ['cubic_ft' => 8000,  'sq_ft' => 700,  'running_ft' => 70],
        ];

        $sp_key = isset($defaults[$species]) ? $species : 'default';
        $unit_key = isset($defaults[$sp_key][$unit]) ? $unit : 'cubic_ft';
        $price_per_unit = $defaults[$sp_key][$unit_key];
        
        $estimate = round($volume * $price_per_unit, 2);
        
        return [
            'estimate' => $estimate,
            'price_per_unit' => $price_per_unit,
            'source' => 'default_rates'
        ];
    }

    /**
     * Calculate Wastage percentage during conversion
     * @param float $source_volume Original volume (e.g., Log)
     * @param float $out_volume Resulting volume (e.g., Sawn)
     * @return array [wastage_vol, wastage_pct, yield_pct, tip]
     */
    public function calculate_wastage_complex($source_volume, $out_volume)
    {
        if ($source_volume <= 0) return ['wastage_vol' => 0, 'wastage_pct' => 0, 'yield_pct' => 0, 'tip' => 'Invalid source volume'];
        
        $wastage_vol  = $source_volume - $out_volume;
        $wastage_pct  = round(($wastage_vol / $source_volume) * 100, 2);
        $yield_pct    = round(100 - $wastage_pct, 2);
        
        $tip = $wastage_pct > 40
            ? 'Wastage is high — consider sharpening saw blades or improving technique.'
            : ($wastage_pct < 20 ? 'Excellent yield — within best-practice range.' : 'Wastage is within normal Sri Lanka sawmill range (20-40%).');

        return [
            'wastage_vol' => $wastage_vol,
            'wastage_pct' => $wastage_pct,
            'yield_pct' => $yield_pct,
            'tip' => $tip
        ];
    }
}
