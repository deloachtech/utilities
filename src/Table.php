<?php
/*
 * This file is part of the deloachtech/utilities package.
 *
 * Copyright (c) DeLoach Tech
 * https://deloachtech.com
 *
 * This source code is protected under international copyright law. All
 * rights reserved and protected by the copyright holders. This file is
 * confidential and only available to authorized individuals with the
 * permission of the copyright holder. If you encounter this file, and do
 * not have permission, please contact the copyright holder and delete
 * this file. Unauthorized copying of this file, via any medium is strictly
 * prohibited.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DeLoachTech\Utilities;

class Table
{

    private $id;
    private $class;
    private $attributes;

    private $columns;
    private $rows;


    public function __construct(string $id = null, string $class = null, array $attributes = [])
    {
        $this->id = $id;
        $this->class = $class;
        $this->attributes = $attributes;
    }


    public function getTable(): string
    {
        $attributes = '';
        foreach ($this->attributes as $k => $v) {
            $attributes .= " {$k}=\"{$v}\" ";
        }

        $id = $this->id ? " id=\"{$this->id}\"": "";
        $class = $this->id ? " class=\"{$this->class}\"": "";

        return <<<STR
<table{$id}{$class}{$attributes}>
<thead>
{$this->getColumns()}
</thead>
<tbody>
{$this->getRows()}
</tbody>
</table>
STR;


    }


    public function setColumn(string $title, bool $condition = true): Table
    {
        $this->columns[] = [$title, $condition];
        return $this;
    }


    public function setRow(array $row): Table
    {
        $this->rows[] = $row;
        return $this;
    }


    private function getColumns(): string
    {
        $columns = '<tr>';
        foreach ($this->columns as $column) {
            if ($column[1]) {
                $columns .= "<th>{$column[0]}</th>";
            }
        }
        $columns .= '</tr>';
        return $columns;
    }


    private function getRows(): string
    {
        $rows = '';
        for ($i = 0; $i < count($this->rows ?? []); $i++) {
            $rows .= '<tr class="' . ($i % 2 == 0 ? 'even' : 'odd') . '">';
            for ($j = 0; $j < count($this->rows[$i] ?? []); $j++) {
                if ($this->columns[$j][1]) {
                    $rows .= "<td>{$this->rows[$i][$j]}</td>";
                }
            }
            $rows .= "</tr>";
        }
        return $rows;
    }

}