<?php declare(strict_types=1);
/**
 * This file is part of the PHP Privacy project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenPGP\Enum;

/**
 * Armor type enum
 *
 * @package  OpenPGP
 * @category Enum
 * @author   Nguyen Van Nguyen - nguyennv1981@gmail.com
 */
enum ArmorType {
    case MultipartSection;

    case MultipartLast;

    case SignedMessage;

    case Message;

    case PublicKey;

    case PrivateKey;

    case Signature;
}
