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

use phpseclib3\Crypt\EC;
use phpseclib3\Crypt\EC\PrivateKey;
use phpseclib3\Crypt\EC\Formats\Keys\PKCS8;
use phpseclib3\File\ASN1;
use phpseclib3\Math\BigInteger;
use OpenPGP\Common\Helper;
use OpenPGP\Enum\CurveOid;

/**
 * ECDSA secret parameters class
 * 
 * @package   OpenPGP
 * @category  Packet
 * @author    Nguyen Van Nguyen - nguyennv1981@gmail.com
 * @copyright Copyright © 2023-present by Nguyen Van Nguyen.
 */
class ECDSASecretParameters extends ECSecretParameters implements SignableParametersInterface
{
    use DSASigningTrait;

    /**
     * Constructor
     *
     * @param BigInteger $d
     * @param ECDSAPublicParameters $publicParams
     * @param PrivateKey $privateKey
     * @return self
     */
    public function __construct(
        BigInteger $d,
        ECDSAPublicParameters $publicParams,
        ?PrivateKey $privateKey = null
    )
    {
        parent::__construct($d, $publicParams, $privateKey);
    }

    /**
     * Reads parameters from bytes
     *
     * @param string $bytes
     * @param ECDSAPublicParameters $publicParams
     * @return ECDSASecretParameters
     */
    public static function fromBytes(
        string $bytes, ECDSAPublicParameters $publicParams
    ): ECDSASecretParameters
    {
        return new ECDSASecretParameters(
            Helper::readMPI($bytes),
            $publicParams
        );
    }

    /**
     * Generates parameters by using EC create key
     *
     * @param CurveOid $curve
     * @return ECDSASecretParameters
     */
    public static function generate(CurveOid $curveOid): ECDSASecretParameters
    {
        switch ($curveOid) {
            case CurveOid::Ed25519:
            case CurveOid::Curve25519:
                throw new \InvalidArgumentException(
                    "{$curveOid->name} is not supported for ECDSA key generation"
                );
            default:
                $privateKey = EC::createKey($curveOid->name);
                $key = PKCS8::load($privateKey->toString('PKCS8'));
                return new ECDSASecretParameters(
                    $key['dA'],
                    new ECDSAPublicParameters(
                        ASN1::encodeOID($curveOid->value),
                        Helper::bin2BigInt($privateKey->getEncodedCoordinates()),
                        $privateKey->getPublicKey()
                    ),
                    $privateKey,
                );
        }
    }
}
