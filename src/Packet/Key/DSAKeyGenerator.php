<?php declare(strict_types=1);
/**
 * This file is part of the PHP PG library.
 *
 * © Nguyen Van Nguyen <nguyennv1981@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenPGP\Packet\Key;

use phpseclib3\Crypt\Common\PrivateKey;
use phpseclib3\Crypt\DSA;
use OpenPGP\Enum\DHKeySize;

/**
 * DSA key generator class
 * 
 * @package   OpenPGP
 * @category  Packet
 * @author    Nguyen Van Nguyen - nguyennv1981@gmail.com
 * @copyright Copyright © 2023-present by Nguyen Van Nguyen.
 */
class DSAKeyGenerator implements KeyGeneratorInterface
{
    /**
     * Constructor
     *
     * @param DHKeySize $keySize
     * @return self
     */
    public function __construct(
        private DHKeySize $keySize
    )
    {
    }

    /**
     * {@inheritdoc}
     */
    public function generate(): PrivateKey
    {
        return DSA::createKey($this->keySize->lSize(), $this->keySize->nSize());
    }
}