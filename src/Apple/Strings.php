<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple;

use Stringable;
use function implode;
use function sprintf;
use const PHP_EOL;

/**
 * Class Strings
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple
 * @since 2.0.0
 */
final class Strings implements Stringable
{

    private const array ESCAPES = [
        "\n" => "\\n",
        "\r" => "\\r",
        "\"" => "\\\"",
        "\\" => "\\\\"
    ];

    /**
     * Strings constructor.
     *
     * @param string $language
     * @param array<string, string> $strings
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct(
        public readonly string $language,
        private array $strings = []
    ) {}

    /**
     * Adds a string.
     *
     * @param string $key
     * @param string $value
     *
     * @return $this
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function add(string $key, string $value): self
    {
        $key = $this->escape($key);
        $value = $this->escape($value);

        $this->strings[$key] = $value;

        return $this;
    }

    /**
     * Escapes the string.
     *
     * @param string $str
     *
     * @return string
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    private function escape(string $str): string
    {
        return strtr($str, self::ESCAPES);
    }

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __toString(): string
    {
        $lines = [];

        foreach ($this->strings as $key => $value) {
            $lines[] = sprintf('"%s" = "%s";', $key, $value);
        }

        return implode(PHP_EOL, $lines);
    }

}
