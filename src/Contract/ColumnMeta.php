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

interface ColumnMeta
{
    public function nativeType(): string;
    public function driverDeclaredType(): ?string;
    public function flags(): array;
    public function name(): string;
    public function table(): string;
    public function length(): int;
    public function precision(): int;
    public function pdoType(): int;
}
