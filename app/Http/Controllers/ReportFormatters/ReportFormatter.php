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

namespace Emotionally\Http\Controllers\ReportFormatters;


abstract class ReportFormatter
{
    /**
     * @var string The title of the document
     */
    protected $title;

    /**
     * @var array The report of the presentation
     */
    protected $report;

    /**
     * ReportFormatter constructor.
     * @param string $title The title of the presentation.
     * @param array|string $report The report to be presented.
     */
    public function __construct(string $title, $report)
    {
        $this->title = trim($title);

        if (is_string($report)) {
            $report = json_decode($report, true);
        } elseif (!is_array($report)) {
            throw new \InvalidArgumentException('$report must be a string or an array');
        }
        $this->report = $report;
    }

    /**
     * Output the file as a binary string.
     * @throws \Exception
     */
    public abstract function getFileAsBinaryOutput();

    /**
     * Generate the default file.
     * @return $this
     */
    public abstract function generateDefault();

    /**
     * Get the base name (the name without extension) of the output file.
     * It consist of an ISO timestamp and the document title.
     * @return string The base name of the output file.
     */
    protected function getFileBaseName()
    {
        try {
            $date = new \DateTime();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return '00000000T000000 - ' . $this->title;
        }
        $base_iso_date_format = 'Ymd\THis';
        return $date->format($base_iso_date_format) . ' - ' . $this->title;
    }

    /**
     * Get the name (with the extension) of the output file.
     * It consist of an ISO timestamp, the document title and the extension.
     * @return string The file name.
     */
    public abstract function getFileName();
}
