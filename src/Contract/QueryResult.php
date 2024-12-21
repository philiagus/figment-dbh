<?php
/*
 * This file is part of philiagus/figment-dbh
 *
 * (c) Andreas Eicher <philiagus@philiagus.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Philiagus\Figment\DBH\Contract;

use Philiagus\Figment\DBH\FetchMode;

interface QueryResult
{
    public \PDOStatement $statement {
        get;
    }

    public int $columnCount {
        get;
    }

    // row
    public function fetchRow(FetchMode $fetchMode = FetchMode::ASSOC): false|array;

    public function iterateRows(FetchMode $fetchMode = FetchMode::ASSOC): iterable;

    public function allRows(FetchMode $fetchMode = FetchMode::ASSOC): array;

    // object
    public function fetchObject(
        string $class = \stdClass::class,
        array  $constructorArguments = [],
        bool   $classNameInFirstColumn = false,
        bool   $propertiesAfterConstructor = false
    ): false|object;

    public function iterateObjects(
        string $class = \stdClass::class,
        array  $constructorArguments = [],
        bool   $classNameInFirstColumn = false,
        bool   $propertiesAfterConstructor = false
    ): iterable;

    public function allObjects(
        string $class = \stdClass::class,
        array  $constructorArguments = [],
        bool   $classNameInFirstColumn = false,
        bool   $propertiesAfterConstructor = false
    ): array;

    // column
    public function fetchColumn(int $column = 0): mixed;

    public function iterateColumn(int $column = 0): iterable;

    public function allColumn(int $column = 0): array;

    public function iterateKeyValue(): iterable;

    public function allKeyValue(): array;

    // callback
    public function fetchCallback(\Closure $callback): mixed;

    public function iterateCallback(\Closure $callback): iterable;

    public function allCallback(\Closure $callback): array;

    public function columnMeta(int $column): ColumnMeta;
}
