<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class DiaSheet implements FromArray, WithTitle, WithStyles, WithColumnWidths
{
    protected $dia;
    protected $zonaNombre;
    protected $filasCategoria = [];
    protected $filasSeparacion = [];
    protected $filaTotal;

    public function __construct(array $dia, string $zonaNombre)
    {
        $this->dia = $dia;
        $this->zonaNombre = $zonaNombre;
    }

    public function title(): string
    {
        return ucfirst(mb_strtolower($this->dia['nombre'], 'UTF-8'));
    }

    public function array(): array
    {
        $dia = $this->dia;

        $filas = [
            ['PRODUCCIÓN DE PEDIDOS GLOBALES'],
            [$dia['nombre']],
            ['FECHA:', Carbon::parse($dia['fecha'])->format('d/m/Y')],
            ['ZONA:', $this->zonaNombre],
            [],
            ['PRODUCTO', 'CHICO', 'GRANDE', 'TAMAÑO ÚNICO'],
        ];

        $resumenPorCategoria = $dia['resumen']->groupBy('categoria');

        $totales = [
            'CHICO' => 0,
            'GRANDE' => 0,
            'TAMAÑO ÚNICO' => 0,
        ];

        foreach ($resumenPorCategoria as $categoria => $productos) {

            $this->filasCategoria[] = count($filas) + 1;

            $filas[] = [$categoria, '', '', ''];

            foreach ($productos as $producto) {

                $filas[] = [
                    $producto['producto'],
                    $producto['variantes']['CHICO'] ?? 0,
                    $producto['variantes']['GRANDE'] ?? 0,
                    $producto['variantes']['TAMAÑO ÚNICO'] ?? 0,
                ];

                // Registrar fila de separación entre categorías.
                $this->filasSeparacion[] = count($filas) + 1;

                // Agregar espacio vacío.
                $filas[] = ['', '', '', ''];

                // Excluir minis y panqués de los totales de pasteles.
                if (str_contains(
                    mb_strtoupper($producto['categoria'], 'UTF-8'),
                    'MINIS Y PANQUES'
                )) {
                    continue;
                }

                foreach ($totales as $variante => $total) {
                    $totales[$variante] +=
                        $producto['variantes'][$variante] ?? 0;
                }
            }
        }

        $filas[] = [
            'TOTAL DE PASTEL',
            $totales['CHICO'],
            $totales['GRANDE'],
            $totales['TAMAÑO ÚNICO'],
        ];

        $this->filaTotal = count($filas);

        // Espacio debajo de la tabla.
        $filas[] = ['', '', '', ''];

        return $filas;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('B4:D4');

        // Título principal.
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '047857'],
            ],
            'alignment' => [
                'horizontal' => 'center',
            ],
        ]);

        // Nombre del día.
        $sheet->getStyle('A2:D2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 13,
                'color' => ['rgb' => '475569'],
            ],
            'alignment' => [
                'horizontal' => 'center',
            ],
        ]);

        $sheet->getStyle('A3:A4')->getFont()->setBold(true);

        // Encabezados de productos.
        $sheet->getStyle('A6:D6')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => 'F08CF0'],
            ],
            'alignment' => [
                'horizontal' => 'center',
            ],
        ]);

        // Categorías.
        foreach ($this->filasCategoria as $fila) {

            $sheet->mergeCells("A{$fila}:D{$fila}");

            $sheet->getStyle("A{$fila}:D{$fila}")->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'F08CF0'],
                ],
            ]);
        }

        // Total final.
        $sheet->getStyle("A{$this->filaTotal}:D{$this->filaTotal}")
            ->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '000000'],
                ],
                'alignment' => [
                    'horizontal' => 'center',
                ],
            ]);

        // Bordes.
        $ultimaFila = $sheet->getHighestRow();

        $sheet->getStyle("A6:D{$ultimaFila}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle('thin');

        // Cantidades centradas y con separador de miles.
        if ($ultimaFila >= 7) {
            $sheet->getStyle("B7:D{$ultimaFila}")
                ->getAlignment()
                ->setHorizontal('center');

            $sheet->getStyle("B7:D{$ultimaFila}")
                ->getNumberFormat()
                ->setFormatCode('#,##0');
        }

        $sheet->freezePane('A7');

        $sheet->getRowDimension($this->filaTotal + 1)
    ->setRowHeight(15);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 38,
            'B' => 18,
            'C' => 18,
            'D' => 20,
        ];
    }
}
