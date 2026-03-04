<?php

namespace App\Services;

use Illuminate\Support\Collection;

class FinancialCalculationService
{
    public function calculate(
        array $items,
        float $descuento = 0,
        float $iva = 0,
        float $retencionIva = 0,
        float $retencionIsr = 0
    ): array {

        $subtotal = collect($items)->sum(function ($item) {
            return $item['cantidad'] * $item['precio_unitario'];
        });

        $total = $subtotal
                - $descuento
                + $iva
                - $retencionIva
                - $retencionIsr;

        return [
            'subtotal' => round($subtotal, 2),
            'descuento' => round($descuento, 2),
            'iva' => round($iva, 2),
            'retencion_iva' => round($retencionIva, 2),
            'retencion_isr' => round($retencionIsr, 2),
            'total' => round($total, 2),
            'total_letra' => $this->convertToWords($total)
        ];
    }

    private function convertToWords(float $amount): string
    {
        $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
        return strtoupper($formatter->format($amount)) . ' PESOS';
    }
}