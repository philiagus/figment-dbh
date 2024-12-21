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

namespace Philiagus\Figment\DBH;

class QueryResult implements Contract\QueryResult
{

    public int $columnCount {
        get => $this->columnCount ??= $this->statement->columnCount();
    }

    /**
     * @param \PDOStatement $statement
     */
    public function __construct(public readonly \PDOStatement $statement)
    {
    }

    public function allRows(FetchMode $fetchMode = FetchMode::ASSOC): array
    {
        return $this->statement->fetchAll($fetchMode->value);
    }

    public function iterateObjects(
        string $class = \stdClass::class,
        array  $constructorArguments = [],
        bool   $classNameInFirstColumn = false,
        bool   $propertiesAfterConstructor = false
    ): iterable
    {
        while ($object = $this->fetchObject($class, $constructorArguments, $classNameInFirstColumn, $propertiesAfterConstructor)) {
            yield $object;
        }
    }

    public function fetchObject(
        string $class = \stdClass::class,
        array  $constructorArguments = [],
        bool   $classNameInFirstColumn = false,
        bool   $propertiesAfterConstructor = false
    ): false|object
    {
        $mode = \PDO::FETCH_CLASS
            | ($classNameInFirstColumn ? \PDO::FETCH_CLASSTYPE : 0)
            | ($propertiesAfterConstructor ? \PDO::FETCH_PROPS_LATE : 0);
        $this->statement->setFetchMode($mode, $class, $constructorArguments);
        return $this->statement->fetch();
    }

    public function allObjects(string $class = \stdClass::class, array $constructorArguments = [], bool $classNameInFirstColumn = false, bool $propertiesAfterConstructor = false): array
    {
        $mode = \PDO::FETCH_CLASS
            | ($classNameInFirstColumn ? \PDO::FETCH_CLASSTYPE : 0)
            | ($propertiesAfterConstructor ? \PDO::FETCH_PROPS_LATE : 0);
        return $this->statement->fetchAll($mode, $class, $constructorArguments);
    }

    public function fetchColumn(int $column = 0): mixed
    {
        return $this->statement->fetchColumn($column);
    }

    public function iterateColumn(int $column = 0): iterable
    {
        $this->statement->setFetchMode(\PDO::FETCH_COLUMN, $column);
        yield from $this->statement->getIterator();
    }

    public function allColumn(int $column = 0): array
    {
        return $this->statement->fetchAll(\PDO::FETCH_COLUMN, $column);
    }

    public function iterateKeyValue(): iterable
    {
        $this->statement->setFetchMode(\PDO::FETCH_KEY_PAIR);
        foreach ($this->statement->getIterator() as $array) {
            yield from $array;
        }
    }

    public function allKeyValue(): array
    {
        return $this->statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function fetchCallback(\Closure $callback): mixed
    {
        return $callback(...$this->fetchRow(FetchMode::ASSOC));
    }

    public function fetchRow(FetchMode $fetchMode = FetchMode::ASSOC): false|array
    {
        return $this->statement->fetch($fetchMode->value);
    }

    public function iterateCallback(\Closure $callback): iterable
    {
        foreach ($this->iterateRows(FetchMode::ASSOC) as $index => $row) {
            yield $index => $callback(...$row);
        }
    }

    public function iterateRows(FetchMode $fetchMode = FetchMode::ASSOC): iterable
    {
        while ($row = $this->statement->fetch($fetchMode->value)) {
            yield $row;
        }
    }

    public function allCallback(\Closure $callback): array
    {
        return $this->statement->fetchAll(\PDO::FETCH_FUNC, $callback);
    }

    public function columnMeta(int $column): Contract\ColumnMeta
    {
        $meta = $this->statement->getColumnMeta($column);
        return new ColumnMeta(
            $meta['native_type'],
            $meta['driver:decl_type'] ?? null,
            $meta['flags'],
            $meta['name'],
            $meta['table'],
            $meta['len'],
            $meta['precision'],
            $meta['pdo_type']
        );
    }
}
