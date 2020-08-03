<?php
/**
 * This file is part of Emotionally.
 *
 * Emotionally is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Emotionally is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Emotionally.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Emotionally\Http\Controllers\ReportFormatters\Spreadsheets;


class ProjectSpreadsheet extends ReportSpreadsheet
{
    /**
     * @inheritDoc
     */
    public function generateDefault()
    {
        $sheet = $this->spreadsheet->getActiveSheet();
        if (!empty($this->report)) {
            $sheet->setCellValue('A1', 'Key');
            $sheet->getStyle('A1')->getFont()->setBold(true);
            $sheet->setCellValue('B1', 'Value');
            $sheet->getStyle('B1')->getFont()->setBold(true);
            $i = 2;
            foreach ($this->report as $index => $value) {
                if ($index == 'Timestamp') {
                    continue;
                }
                $sheet->setCellValue('A' . $i, $index);
                $sheet->getStyle('A'.$i)->getFont()->setBold(true);
                $sheet->setCellValue('B' . $i, $value);
                $i++;
            }
        }
    }
}
