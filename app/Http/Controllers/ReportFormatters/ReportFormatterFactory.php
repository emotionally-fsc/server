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


use Emotionally\Project;
use Emotionally\Video;

class ReportFormatterFactory
{
    const PRESENTATION = 'pptx';
    const SPREADSHEET = 'xlsx';

    /**
     * @var Project|Video The model whose report will be formatted.
     */
    private $model;

    /**
     * @param Project|Video $model
     */
    public function __construct($model)
    {
        if (!$model instanceof Project && !$model instanceof Video) {
            throw  new \InvalidArgumentException('The given "$model" parameter is not a Project nor a Video.');
        }

        $this->model = $model;
    }

    /**
     * @param string $format target format.
     * @return ReportFormatter The converted report
     */
    public function to($format)
    {
        $type = $this->model instanceof Project ? 'Project' : 'Video';

        if ($format == self::PRESENTATION) {
            $formatter = 'Presentations\\' . $type . 'Presentation';
        } elseif ($format == self::SPREADSHEET) {
            $formatter = 'Spreadsheets\\' . $type . 'Spreadsheet';
        } else {
            throw new \InvalidArgumentException('Unsupported format: ' . $format);
        }
        $formatter = '\\' . __NAMESPACE__ . '\\' . $formatter;

        $convertedReport = new $formatter($this->model->name, $this->model->report);
        $convertedReport->generateDefault();

        return $convertedReport;
    }
}
