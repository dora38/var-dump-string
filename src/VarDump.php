<?php

declare(strict_types=1);

namespace VarDumpString;

class VarDump
{
    /**
     * convert into a var_dump-style string.
     *
     * @param mixed $value     The expression to dump.
     * @param mixed ...$values Further expressions to dump.
     * @return string
     */
    public static function toString($value, ...$values): string
    {
        ob_start();
        var_dump($value, ...$values);
        $result = ob_get_clean();
        assert($result !== false);

        return $result;
    }
}
