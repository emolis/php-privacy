<?php declare(strict_types=1);
/**
 * This file is part of the PHP PG library.
 *
 * © Nguyen Van Nguyen <nguyennv1981@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenPGP\Cryptor\Asymmetric;

use phpseclib3\Crypt\Common\AsymmetricKey;
use phpseclib3\Math\BigInteger;

/**
 * ElGamal class
 *
 * @package    OpenPGP
 * @category   Cryptor
 * @author     Nguyen Van Nguyen - nguyennv1981@gmail.com
 * @copyright  Copyright © 2023-present by Nguyen Van Nguyen.
 */
abstract class ElGamal extends AsymmetricKey
{
    /**
     * Algorithm Name
     */
    const ALGORITHM = 'ElGamal';

    private int $bitSize;

    /**
     * Constructor
     *
     * @param BigInteger $y
     * @param BigInteger $prime
     * @param BigInteger $generator
     * @return self
     */
    public function __construct(
        private BigInteger $y,
        private BigInteger $prime,
        private BigInteger $generator
    )
    {
        $this->bitSize = $prime->getLength();
    }

    /**
     * Create public / private key pair.
     *
     * Returns the private key, from which the publickey can be extracted
     *
     * @param int $lSize
     * @param int $nSize
     * @return ElGamalPrivateKey
     */
    public static function createKey(int $lSize = 2048, int $nSize = 224): ElGamalPrivateKey
    {
        $two = new BigInteger(2);
        $q = BigInteger::randomPrime($nSize);
        $divisor = $q->multiply($two);
        do {
            $x = BigInteger::random($lSize);
            list(, $c) = $x->divide($divisor);
            $p = $x->subtract($c->subtract(self::$one));
        } while ($p->getLength() != $lSize || !$p->isPrime());

        $p_1 = $p->subtract(self::$one);
        list($e) = $p_1->divide($q);

        $h = clone $two;
        while (true) {
            $g = $h->powMod($e, $p);
            if (!$g->equals(self::$one)) {
                break;
            }
            $h = $h->add(self::$one);
        }

        $x = BigInteger::randomRange(self::$one, $q->subtract(self::$one));
        $y = $g->powMod($x, $p);
        return ElGamalPrivateKey($x, $y, $p, $g);
    }

    /**
     * Gets public key value y
     *
     * @return BigInteger
     */
    public function getY(): BigInteger
    {
        return $this->Y;
    }

    /**
     * Gets Prime P
     *
     * @return BigInteger
     */
    public function getPrime(): BigInteger
    {
        return $this->prime;
    }

    /**
     * Gets Group Generator G
     *
     * @return BigInteger
     */
    public function getGenerator(): BigInteger
    {
        return $this->generator;
    }

    /**
     * Gets bit size
     *
     * @return int
     */
    public function getBitSize(): int
    {
        return $this->bitSize;
    }
}