<?php

namespace App\Traits;

trait ExcelSheetModificationTrait
{
    public $alphabet = [];

    public function getColumnStart($key, $row): string
    {
        $item_key = array_search($key, $row);
        $fraction = $item_key / 26;
        if ($fraction < 1) {
            return $this->alphabet[$item_key];
        } else {
            $first_letter = $this->alphabet[floor($fraction) - 1];
            $second_letter = $this->alphabet[$item_key - (floor($fraction) * 26)];

            return $first_letter.$second_letter;
        }
    }

    public function getColumnEnd($key, $row): string
    {
        $item_key = array_search($key, $row);
        $fraction = $item_key / 26;

        if ($fraction < 1) {
            if ($item_key - 1 <= 0) {
                return $this->alphabet[$item_key];
            }

            return $this->alphabet[$item_key - 1];
        } else {
            $second_key = $item_key - (floor($fraction) * 26) - 1;
            if ($second_key < 0) {
                $second_key = 25;
                if (floor($fraction) - 1 <= 0) {
                    return $this->alphabet[$second_key];
                } else {
                    $first_letter = $this->alphabet[floor($fraction) - 2];
                    $second_letter = $this->alphabet[$second_key];

                    return $first_letter.$second_letter;
                }
            } else {
                $first_letter = $this->alphabet[floor($fraction) - 1];
                $second_letter = $this->alphabet[$item_key - (floor($fraction) * 26) - 1];

                return $first_letter.$second_letter;
            }
        }
    }

    protected function paddArray(array $initial, int $length, string $direction = 'end'): array
    {
        $array = $initial;

        for ($i = count($array); $i < $length; $i++) {
            if ($direction === 'end') {
                $array[] = '';
            } else {
                array_unshift($array, '');
            }
        }

        return $array;
    }

    protected function styleColumns($sheet, $start, $end, $row_start, $row_end, $color, $ending = false)
    {
        $column_start = $this->getColumnStart($start, $row_start);
        $column_end = ! $ending ? $this->getColumnEnd($end, $row_end) : $this->getColumnStart($end, $row_end);

        for ($row = 1; $row <= count($this->collection); $row++) {
            $style_span = $column_start.$row.':'.$column_end.$row;
            $sheet->getStyle($style_span)->applyFromArray([
                'font' => [
                    'bold' => false,
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'rgb' => $color,
                    ],
                ],
            ]);
        }
    }

    protected function addAreas($area_array, $main_header, $sub_header, $total_string, $total)
    {
        foreach ($area_array as $i => $info) {
            if ($i === 0) {
                $this->main_header_row = array_merge($this->main_header_row, $this->paddArray([$main_header], 8));
                $this->main_sub_row = array_merge($this->main_sub_row, $this->paddArray([$sub_header], 8));
            } else {
                $this->main_header_row = array_merge($this->main_header_row, $this->paddArray([], 8));
                $this->main_sub_row = array_merge($this->main_sub_row, $this->paddArray([], 8));
            }
            $this->sub_header_row = array_merge($this->sub_header_row, $this->room_array);
            $this->info_row = array_merge($this->info_row, [$info['name'], $info['counter'], $info['length'], $info['width'], $info['surface'], $info['heated'], $info['cooling'], $info['points']]);
        }
        if (count($area_array) > 0) {
            $this->main_header_row = array_merge($this->main_header_row, ['']);
            $this->main_sub_row = array_merge($this->main_sub_row, ['']);
            $this->sub_header_row = array_merge($this->sub_header_row, [$total_string]);
            $this->info_row = array_merge($this->info_row, [$total]);
        }
    }

    protected function addSharedAreas($area_array, $main_header, $sub_header, $total_string, $total)
    {
        foreach ($area_array as $sh => $share) {
            if ($sh === 0) {
                $this->main_header_row = array_merge($this->main_header_row, $this->paddArray([$main_header], 9));
                $this->main_sub_row = array_merge($this->main_sub_row, $this->paddArray([$sub_header], 9));
            } else {
                $this->main_header_row = array_merge($this->main_header_row, $this->paddArray([], 9));
                $this->main_sub_row = array_merge($this->main_sub_row, $this->paddArray([], 9));
            }
            $this->sub_header_row = array_merge($this->sub_header_row, $this->shared_room_array);
            $this->info_row = array_merge($this->info_row, [
                $share['name'],
                $share['counter'],
                $share['length'],
                $share['width'],
                $share['surface'],
                array_key_exists('shared_with', $share) ? ($share['shared_with'] == '1' ? 'Ja' : 'Nee') : 'Nee',
                array_key_exists('amount', $share) ? $share['amount'] : '-',
                array_key_exists('address_count', $share) ? $share['address_count'] : '-',
                $share['points'],
            ]);
        }
        if (count($area_array) > 0) {
            $this->main_header_row = array_merge($this->main_header_row, ['']);
            $this->main_sub_row = array_merge($this->main_sub_row, ['']);
            $this->sub_header_row = array_merge($this->sub_header_row, [$total_string]);
            $this->info_row = array_merge($this->info_row, [$total]);
        }
    }

    protected function fillKitchens($kitchen_array)
    {
        foreach ($kitchen_array as $k => $kitchen) {
            if ($k === 0) {
                $this->main_header_row = array_merge($this->main_header_row, $this->paddArray([], 3));
                $this->main_sub_row = array_merge($this->main_sub_row, $this->paddArray(['Keukens'], 3));
            } else {
                $this->main_header_row = array_merge($this->main_header_row, $this->paddArray([], 3));
                $this->main_sub_row = array_merge($this->main_sub_row, $this->paddArray([], 3));
            }

            $this->sub_header_row = array_merge($this->sub_header_row, ['Naam', 'Lengte aanrecht', 'Aanrecht punten']);
            $this->info_row = array_merge($this->info_row, [$kitchen['index'], $kitchen['type'], $kitchen['type_points']]);

            if (count($kitchen['extra_facilities'])) {
                foreach ($kitchen['extra_facilities'] as $f => $facility) {
                    if ($f === 0) {
                        $this->main_header_row = array_merge($this->main_header_row, $this->paddArray([], 3));
                        $this->main_sub_row = array_merge($this->main_sub_row, $this->paddArray(['Faciliteiten '.$kitchen['index']], 3));
                    } else {
                        $this->main_header_row = array_merge($this->main_header_row, $this->paddArray([], 3));
                        $this->main_sub_row = array_merge($this->main_sub_row, $this->paddArray([], 3));
                    }
                    $this->sub_header_row = array_merge($this->sub_header_row, ['Faciliteit', 'Aantal', 'Punten']);
                    $this->info_row = array_merge($this->info_row, [$facility['name'], $facility['amount'], $facility['points']]);
                }
                $this->main_header_row = array_merge($this->main_header_row, $this->paddArray([], 1));
                $this->main_sub_row = array_merge($this->main_sub_row, $this->paddArray([], 1));
                $this->sub_header_row = array_merge($this->sub_header_row, ['Totaal faciliteiten']);
                $this->info_row = array_merge($this->info_row, [$kitchen['facility_total']]);
            }

            $this->main_header_row = array_merge($this->main_header_row, ['', '']);
            $this->main_sub_row = array_merge($this->main_sub_row, ['', '']);
            $this->sub_header_row = array_merge($this->sub_header_row, ['Opmerkingen', 'Totaal '.$kitchen['index']]);
            $this->info_row = array_merge($this->info_row, [$kitchen['message'], $kitchen['total']]);
        }
    }

    protected function fillBathrooms($bathroom_array)
    {
        foreach ($bathroom_array as $b => $bathroom) {
            if ($b === 0) {
                $this->main_header_row = array_merge($this->main_header_row, $this->paddArray([], 11));
                $this->main_sub_row = array_merge($this->main_sub_row, $this->paddArray(['Badkamers'], 11));
            } else {
                $this->main_header_row = array_merge($this->main_header_row, $this->paddArray([], 11));
                $this->main_sub_row = array_merge($this->main_sub_row, $this->paddArray([], 11));
            }

            $this->sub_header_row = array_merge($this->sub_header_row, ['Naam', 'Badkamer voorziening', 'Voorziening punten', 'Aantal toiletten', 'Punten', 'Aantal zwevende toiletten', 'Punten', 'Aantal wastafels', 'Punten', 'Aantal meerpersoons wastafels', 'Punten']);
            $this->info_row = array_merge($this->info_row, [$bathroom['index'], $bathroom['type'], $bathroom['type_points'], $bathroom['toilet_count'], $bathroom['toilet'], $bathroom['floating_toilet_count'], $bathroom['floating_toilet'], $bathroom['washbasin_count'], $bathroom['washbasin'], $bathroom['multi_washbasin_count'], $bathroom['multi_washbasin']]);

            if (count($bathroom['extra_facilities']) > 0) {
                foreach ($bathroom['extra_facilities'] as $ap => $appliance) {
                    if ($ap === 0) {
                        $this->main_header_row = array_merge($this->main_header_row, $this->paddArray([], 3));
                        $this->main_sub_row = array_merge($this->main_sub_row, $this->paddArray(['Apparatuur '.$bathroom['index']], 3));
                    } else {
                        $this->main_header_row = array_merge($this->main_header_row, $this->paddArray([], 3));
                        $this->main_sub_row = array_merge($this->main_sub_row, $this->paddArray([], 3));
                    }
                    $this->sub_header_row = array_merge($this->sub_header_row, ['Faciliteit', 'Aantal', 'Punten']);
                    $this->info_row = array_merge($this->info_row, [$appliance['name'], $appliance['amount'], $appliance['points']]);
                }
                $this->main_header_row = array_merge($this->main_header_row, $this->paddArray([], 1));
                $this->main_sub_row = array_merge($this->main_sub_row, $this->paddArray([], 1));
                $this->sub_header_row = array_merge($this->sub_header_row, ['Totaal faciliteiten']);
                $this->info_row = array_merge($this->info_row, [$bathroom['extra_facilities_total']]);
            }
            $this->main_header_row = array_merge($this->main_header_row, $this->paddArray([], 2));
            $this->main_sub_row = array_merge($this->main_sub_row, $this->paddArray([], 2));
            $this->sub_header_row = array_merge($this->sub_header_row, ['Opmerkingen', 'Totaal '.$bathroom['index']]);
            $this->info_row = array_merge($this->info_row, [! empty($bathroom['message']) ? $bathroom['message'] : '-', $bathroom['total']]);
        }
    }
}
