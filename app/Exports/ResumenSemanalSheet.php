<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ResumenSemanalSheet implements FromArray, WithTitle, WithStyles, WithColumnWidths
{
    protected $datos;
    protected $filasCategoria = [];
    protected $filasSeparacion = [];
    protected $filaEncabezado = 7;
    protected $filaTotal;

    public function __construct(array $datos)
    {
        $this->datos = $datos;
    }

    public function title(): string
    {
        return 'Resumen semanal';
    }

    public function array(): array
    {
        $datos = $this->datos;

        $filas = [
            ['PEDIDOS GLOBALES'],
            ['CONSOLIDADO DE PRODUCCIÓN'],
            [
                'SEMANA:',
                $datos['inicioSemana']->format('d/m/Y'),
                'AL',
                $datos['finSemana']->format('d/m/Y'),
            ],
            ['ZONA:', $datos['zonaNombre']],
            ['TOTAL DE PASTELES:', $datos['totalSinMinis']],
            ['TOTAL DE MINIS Y PANQUÉS:', $datos['totalMinis']],
            ['PRODUCTO', 'CHICO', 'GRANDE', 'TAMAÑO ÚNICO'],
        ];

        $resumenPorCategoria = $datos['resumen']->groupBy('categoria');

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
                }

                // Espacio entre categorías.
                $filas[] = ['', '', '', ''];
            }

        $filas[] = [
            'TOTAL DE PASTEL',
            $datos['totalPorVariante']['CHICO'] ?? 0,
            $datos['totalPorVariante']['GRANDE'] ?? 0,
            $datos['totalPorVariante']['TAMAÑO ÚNICO'] ?? 0,
        ];

        $this->filaTotal = count($filas);

        // Espacio debajo de la tabla.
        // Registrar fila de separación entre categorías.
        $this->filasSeparacion[] = count($filas) + 1;

        // Agregar espacio vacío.
        $filas[] = ['', '', '', ''];

        return $filas;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('B4:D4');

        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 18,
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

        $sheet->getStyle('A2:D2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => '475569'],
            ],
            'alignment' => [
                'horizontal' => 'center',
            ],
        ]);

        $sheet->getStyle('A3:D6')->getFont()->setBold(true);

        $sheet->getStyle('A7:D7')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => 'F08CF0'],
            ],
            'alignment' => [
                'horizontal' => 'center',
            ],
        ]);

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

        $ultimaFila = $sheet->getHighestRow();

        $sheet->getStyle("A7:D{$ultimaFila}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle('thin');

        $sheet->getStyle("B8:D{$ultimaFila}")
            ->getAlignment()
            ->setHorizontal('center');

        $sheet->getStyle("B5:B6")
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        $sheet->getStyle("B8:D{$ultimaFila}")
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        $sheet->freezePane('A8');

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