<?php

/**
 * This file is part of the komtet/kassa-sdk library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Komtet\KassaSdk;

class Vat
{
    /**
     * Without VAT
     */
    const RATE_NO = 'no';

    /**
     * 0%
     */
    const RATE_0 = '0';

    /**
     * 5%
     */
    const RATE_5 = '5';

    /**
     * 7%
     */
    const RATE_7 = '7';

    /**
     * 10%
     */
    const RATE_10 = '10';

    /**
     * 20%
     */
    const RATE_20 = '20';

    /**
     * 5/105
     */
    const RATE_105 = '105';

    /**
     * 7/107
     */
    const RATE_107 = '107';

    /**
     * 10/110
     */
    const RATE_110 = '110';

    /**
     * 20/120
     */
    const RATE_120 = '120';

    private $rate;

    /**
     * @param string|int|float $rate See Vat::RATE_*
     *
     * @return Vat
     */
    public function __construct($rate)
    {
        if (!is_string($rate)) {
            $rate = (string) $rate;
        }

        $rate = str_replace(array('0.', '%'), '', $rate);

        switch ($rate) {
            case '5/105':
                $rate = static::RATE_105;
                break;
            case '7/107':
                $rate = static::RATE_107;
                break;
            case '10/110':
                $rate = static::RATE_110;
                break;
            case '20/120':
                $rate = static::RATE_120;
                break;
            default:
                if (!in_array($rate, array(
                    static::RATE_NO,
                    static::RATE_0,
                    static::RATE_5,
                    static::RATE_7,
                    static::RATE_10,
                    static::RATE_20,
                    static::RATE_105,
                    static::RATE_107,
                    static::RATE_110,
                    static::RATE_120
                ))) {
                    throw new \InvalidArgumentException(sprintf('Unknown VAT rate: %s', $rate));
                }
        }

        $this->rate = $rate;
    }

    /**
     * @return string
     */
    public function getRate()
    {
        return $this->rate;
    }
}
