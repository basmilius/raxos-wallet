<?php
declare(strict_types=1);

namespace Raxos\Wallet\Component;

use Raxos\Contract\Wallet\ComponentInterface;
use Raxos\Foundation\Util\ColorUtil;

/**
 * Class Color
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Component
 * @since 2.0.0
 */
final readonly class Color implements ComponentInterface
{

    /**
     * Color constructor.
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct(
        public int $red,
        public int $green,
        public int $blue
    ) {}

    /**
     * Returns the hex representation of the color.
     *
     * @return string
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function toHex(): string
    {
        return ColorUtil::rgbToHex($this->red, $this->green, $this->blue, true);
    }

    /**
     * Returns the rgb representation of the color.
     *
     * @return string
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function toRgb(): string
    {
        return "rgb({$this->red}, {$this->green}, {$this->blue})";
    }

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function jsonSerialize(): string
    {
        return $this->toRgb();
    }

}
