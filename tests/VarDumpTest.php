<?php

declare(strict_types=1);

namespace Tests\Unit\Support\Text;

use PHPUnit\Framework\TestCase;
use VarDumpString\VarDump;

class VarDumpTest extends TestCase
{
    /**
     * @dataProvider toStringDataProvider
     * @param mixed $var       The expression to dump.
     * @param string $expected Expected result string.
     */
    public function testToString($var, string $expected): void
    {
        $this->assertSame($expected, VarDump::toString($var));
    }

    /**
     * @return mixed[][]
     */
    public function toStringDataProvider(): array
    {
        return [
            // string
            [
                'string',
                <<<'EOS'
string(6) "string"

EOS
            ],
            // int
            [
                123456,
                <<<'EOS'
int(123456)

EOS
            ],
            // float
            [
                3.141592,
                <<<'EOS'
float(3.141592)

EOS
            ],
            // bool
            [
                true,
                <<<'EOS'
bool(true)

EOS
            ],
            // null
            [
                null,
                <<<'EOS'
NULL

EOS
            ],
            // array
            [
                ['key1' => 'value1', false, 'key2' => 100],
                <<<'EOS'
array(3) {
  ["key1"]=>
  string(6) "value1"
  [0]=>
  bool(false)
  ["key2"]=>
  int(100)
}

EOS
            ],
            // resource
            [
                STDIN,
                <<<'EOS'
resource(1) of type (stream)

EOS
            ],
        ];
    }

    public function testToStringWithObject(): void
    {
        $object = json_decode('{ "foo": "foo", "bar": 2, "baz": null, "qux": false }', false);
        $result = VarDump::toString($object);
        $expected1 = 'object(stdClass)#';
        $expected2 = <<<'EOS'
 (4) {
  ["foo"]=>
  string(3) "foo"
  ["bar"]=>
  int(2)
  ["baz"]=>
  NULL
  ["qux"]=>
  bool(false)
}

EOS;
        $this->assertStringStartsWith($expected1, $result);
        $this->assertStringEndsWith($expected2, $result);
    }

    public function testToStringWithMultiple(): void
    {
        $var1 = 3.141592;
        $var2 = true;
        $var3 = ['key1' => 'value1', 'key2' => 100];
        $result = VarDump::toString($var1, $var2, $var3);
        $expect = <<<'EOT'
float(3.141592)
bool(true)
array(2) {
  ["key1"]=>
  string(6) "value1"
  ["key2"]=>
  int(100)
}

EOT;
        $this->assertSame($expect, $result);
    }
}
