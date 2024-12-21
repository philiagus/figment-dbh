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

readonly class ColumnMeta implements Contract\ColumnMeta
{

    public function __construct(
        private string  $nativeType,
        private ?string $driverDeclaredType,
        private array   $flags,
        private string  $name,
        private string  $table,
        private int     $length,
        private int     $precision,
        private int     $pdoType)
    {
    }

    public function nativeType(): string
    {
        return $this->nativeType;
    }

    public function driverDeclaredType(): ?string
    {
        return $this->driverDeclaredType;
    }

    public function flags(): array
    {
        return $this->flags;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function table(): string
    {
        return $this->table;
    }

    public function length(): int
    {
        return $this->length;
    }

    public function precision(): int
    {
        return $this->precision;
    }

    public function pdoType(): int
    {
        return $this->pdoType;
    }
}
