<?php declare(strict_types=1);

require_once dirname(__DIR__) . "/vendor/autoload.php";

use OpenPGP\OpenPGP;

$passphase = 'Ax@2bGh;SxD&"A_;El%mPIvLx_!#3Aik';

$keyData = <<<EOT
-----BEGIN PGP PRIVATE KEY BLOCK-----
Version: PHP Privacy v2
Comment: https://github.com/web-of-trust/php-privacy

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
qy6toPKEKnsoCZVMlS/fSSTONakq
=fImQ
-----END PGP PRIVATE KEY BLOCK-----
EOT;
echo "Decrypt RSA private key" . PHP_EOL;
$privateKey = OpenPGP::decryptPrivateKey($keyData, $passphase);
echo "Key algorithm: {$privateKey->getKeyAlgorithm()->name}" . PHP_EOL;
echo "Key version: {$privateKey->getVersion()}" . PHP_EOL;
echo "Key fingerprint: {$privateKey->getFingerprint(true)}" . PHP_EOL;
echo "Key is decrypted: {$privateKey->isDecrypted()}" . PHP_EOL;
echo "User ID: {$privateKey->getPrimaryUser()->getUserID()}" .
    PHP_EOL .
    PHP_EOL;

$keyData = <<<EOT
-----BEGIN PGP PRIVATE KEY BLOCK-----
Version: PHP Privacy v2
Comment: https://github.com/web-of-trust/php-privacy

xcBIBGbzftYTBSuBBAAjBCMEAWHmrzLEzuTRVDQQTvCZdm/RnY/M9rzN8qzpp4lBAFSDhYY118hv
Jp2Ax0rsD5Qi8tMeTAdFef08HqzP4eeNSHu1AZi518zPlyv3ADpZ3jQ89Sw+WwR17a7+0ZuEV8Jd
0gyhyCX9E+D1cxZsziJBIjpNuygqCIhqd9rNzNVd7JizZVkZ/gcDCL4MeAUz7gZd4Ls+mz+hHTJ0
Vjfvt42ia0SIS4EQ9Arg5os4IDybW26s6+tK4uaye+Q8OoqNHBqoLHjwAgWIMFSbm2oNTfWOJ3OW
bY1xHF3xU6NthH6xIgexVN1VRo83OfH9i7J5kIxQ2f7G2ts8GW8ZzSpOZ3V5ZW4gVmFuIE5ndXll
biA8bmd1eWVubnYxOTgxQGdtYWlsLmNvbT7CwDgEEBMKAGcFAmbzftcWIQQKaDUnC4VgjGhq6iRK
MOXn515lRAkQSjDl5+deZUQCGQE8FAAAAAAAEwAgc2FsdEB3ZWJvZnRydXN0Lm9yZ9vIagGLvsuT
rhz3HcgczRpxDHZ/isZuk9JjxV2MxOjkAADSMQIJAVrEKFKzFwaPbioc/uo3OiIgEHs5RNMMDt+7
HNSmSK3/hppyJGlHZ9HJ+PGRjFfefqN3CMbTLca+zIbNjNTtYtHTAgjhRO+F4ecTUZ4FS6p7FYOn
Xh+/6kY/q2Pslvy8h5J/e+BS2tpGNVW8NBkaAodfH72Qfl3DHqCIwBVq3cOB7Y5B2c0sTmd1eWVu
IFZhbiBOZ3V5ZW4gPG5ndXllbm52QGl3YXl2aWV0bmFtLmNvbT7CwDYEEBMKAGQFAmbzftcWIQQK
aDUnC4VgjGhq6iRKMOXn515lRAkQSjDl5+deZUQ8FAAAAAAAEwAgc2FsdEB3ZWJvZnRydXN0Lm9y
Z6VV4IKUt2VuzXWU2m3vBZDIFqafb0vuegRV3Lzin2MOAABbygIJAe+jRxTKvbdW6/7uCkUC9rBr
viuR5XDbfuPEPtY3Zt9BipUBQzEQ4YDRPGi+WmkBC5joVIzO3KgjgEdfTLkhfPBZAgkBtlo1U828
+T6PzxvqtoEegF0ZQHxJDWPIc/yO6FKjPklMy9Rx11ZyOK6RNqy1gDo/P1VnD8Ijd5LRhiBasSpt
HYXHwEwEZvN+1xIFK4EEACMEIwQAaxyKF0GqutGOvqecwNq4EeU3qikm24tuNJd8CfdEETWymtua
aEZD4FUdFqshi+QmJ0RGYB9R9yFpTWJANvZGfDgB/5auAsBvTh5zlQRYcqN/s79HXGgfsHhvBSAE
ruOW3UdPQcD4wdYYi7D3SJUj3m9BjDHDvKmu3A2MSLCgKD8vuAgDAAoJ/gcDCKFUtRsiD7eW4OUz
B47o7XBi8bWWdbDg4L6zs3vCksArGErMpafTxY4zL3vxwh8LxyGOSEfSO/IAtYQvwzGAccDawDgx
9fvQxvdPqzah58fjZZjwRvLe74B4jIt2uUBitJe5SZViEGvqXJQRslRFFLdRwsA4BBgTCgBnBQJm
837XFiEECmg1JwuFYIxoauokSjDl5+deZUQJEEow5efnXmVEAhsMPBQAAAAAABMAIHNhbHRAd2Vi
b2Z0cnVzdC5vcmdiuw5nTdeo697B284O829/BjCcXC+TUfCyEM6cWhGZMQAAeIkCBiVoTUmbUb3e
9QoEjFMYvEBukbaCrJgryimqeTmJAUXMcgQaAyZLJSjEWi+adSEco9jwxl2ERPF4iJXZrgQiOvLK
AgkBOYQwtx3Bwe9wnbmbPzfF85qcoXQ2Lz6t5fmqzlqf3r3OtWzSyWbMEzC1ZdWTFE/RKcLsOhLZ
h2en6HvwU70R0BQ=
=15wT
-----END PGP PRIVATE KEY BLOCK-----
EOT;
echo "Decrypt Ecc private key" . PHP_EOL;
$privateKey = OpenPGP::decryptPrivateKey($keyData, $passphase);
echo "Key algorithm: {$privateKey->getKeyAlgorithm()->name}" . PHP_EOL;
echo "Key version: {$privateKey->getVersion()}" . PHP_EOL;
echo "Key fingerprint: {$privateKey->getFingerprint(true)}" . PHP_EOL;
echo "Key is decrypted: {$privateKey->isDecrypted()}" . PHP_EOL;
echo "User ID: {$privateKey->getPrimaryUser()->getUserID()}" .
    PHP_EOL .
    PHP_EOL;

$keyData = <<<EOT
-----BEGIN PGP PRIVATE KEY BLOCK-----
Version: PHP Privacy v2
Comment: https://github.com/web-of-trust/php-privacy

xX0GZvN+1xsAAAAgMtES26hjSSQoUx6STK6IMe64fLvldCRkg7w50pfRxqD+HQcLAwjPsmWimBb8
n+B+mPc9X1kryrwErHX2103ACvuNq1yGPKvU6q3HygdPL8n7DHv/U5S88R6KQnNQfaIRGsYRpye+
+xw+S2xbvPOA2gsXPMK7Bh8bCAAAAFwFAmbzftciIQYLfjtdj/UV5gHlZfcFMJ6Ke9ev9rKvkcOH
pWTraKKGagkQC347XY/1FeYCGwMDCwcJBCIBAgMFFQgMCg4FFgABAgMCHgsNJwcBCQEHAgkCBwMJ
AwAAAACvoRDdi30uoJ4Qx1mM90rST6SweRqem4vCvIeBio+IASNXehHpunU6cKwMVZDn95CBDNPZ
z2nJgNuGKdAJQDWyOiZiNKI9E6wrV3upyecXMG62C80qTmd1eWVuIFZhbiBOZ3V5ZW4gPG5ndXll
bm52MTk4MUBnbWFpbC5jb20+wr4GEBsIAAAAXwUCZvN+1yIhBgt+O12P9RXmAeVl9wUwnop716/2
sq+Rw4elZOtoooZqCRALfjtdj/UV5gIbAwMLBwkEIgECAwUVCAwKDgUWAAECAwIeCw0nBwEJAQcC
CQIHAwkDAhkBAAAAAKGEECKDSaFeJVntGQNUD76ZK95pLGIIVCXvL9rDH92lz/XrdtMkR5pAKJMc
zP8SiSPx3+zt7pXkFu3eZV2UTLYfGBJK8tUG/yMSCp06noXIHyoLzSxOZ3V5ZW4gVmFuIE5ndXll
biA8bmd1eWVubnZAaXdheXZpZXRuYW0uY29tPsK7BhAbCAAAAFwFAmbzftciIQYLfjtdj/UV5gHl
ZfcFMJ6Ke9ev9rKvkcOHpWTraKKGagkQC347XY/1FeYCGwMDCwcJBCIBAgMFFQgMCg4FFgABAgMC
HgsNJwcBCQEHAgkCBwMJAwAAAABUZxBN8BwLTv+kUMGiDjnhQmFp3c2kxE0pxPt8bVxECyC4dnQy
D7tm7ADA4ARHAewWJBpbrk+ebJQ7UE82t49FWMRafi0Fa+GSgOdwdGONSx19C8d9BmbzftcZAAAA
IBOea5n9NJN1t+BwL3DQ0CSSzz7px4fG2+mUGOMDtUM6/h0HCwMIzDB2lTsp8LzglO8FYN79WOnZ
Fh1xEf4FY+t34w/7G+j50WKZOfSoAUxF9iA+hDmV2eBsEvhIK1lxDQmsk3aKjWC80/hMNPwiChdN
WoTClQYYGwgAAAA2BQJm837XIiEGC347XY/1FeYB5WX3BTCeinvXr/ayr5HDh6Vk62iihmoJEAt+
O12P9RXmAhsMAAAAAFyXEINWSWM0kFOrQi9dSyWz3QwlxuNVkw18lJNG1ERQvqsrk9h4gfATRvIG
iifJtGDxIsDjLBx8u9lEBTPFPKQbMrh4Gx7OL87S2a3yKJlkdsoJ1RexF+OhHlcTHORBJRF1UMiY
9jMDW8IANQ==
=kJoZ
-----END PGP PRIVATE KEY BLOCK-----
EOT;
echo "Decrypt Curve25519 private key" . PHP_EOL;
$privateKey = OpenPGP::decryptPrivateKey($keyData, $passphase);
echo "Key algorithm: {$privateKey->getKeyAlgorithm()->name}" . PHP_EOL;
echo "Key version: {$privateKey->getVersion()}" . PHP_EOL;
echo "Key fingerprint: {$privateKey->getFingerprint(true)}" . PHP_EOL;
echo "Key is decrypted: {$privateKey->isDecrypted()}" . PHP_EOL;
echo "User ID: {$privateKey->getPrimaryUser()->getUserID()}" .
    PHP_EOL .
    PHP_EOL;

$keyData = <<<EOT
-----BEGIN PGP PRIVATE KEY BLOCK-----
Version: PHP Privacy v2
Comment: https://github.com/web-of-trust/php-privacy

xa8GZvN+1xwAAAA5Hf47PIbsLCoImil+MuXWGvUvzElvjIiq3fJrRIf+k1cXre22GEKF01R2q1Ma
mkSDoofsPPeNeUUA/h0HCwMITySmmq2jzrTgYtxFzyFzKGtQNbFTZXcTXmmxqT4UjfG+S5s5tFYy
PG741SHOfNpz10FGD5UzaVRamxnO+or2oUJZcxS6qKR895rPQImQVoQdy8xYfEZkVE2Tl8rXX0M8
YXsyimIqwsA9Bh8cCgAAAFwFAmbzftgiIQajZpX32QU9YiluDfY6DUi6J3MNnD1PcbgqWMinyQ/q
IAkQo2aV99kFPWICGwMDCwcJBCIBAgMFFQgMCg4FFgABAgMCHgsNJwcBCQEHAgkCBwMJAwAAAAAj
xiD+Lo7uvlINPBCHEnAKtdp/Ez8sgWC0M0HsRidCx3TOwdRtseFf4sO758Ti7hyO1BPGsXeHZgqC
XZlPWAOkdyLf56RwS4hS5Zdkj0VXUpbR/178kHmuz+0IAKbvDlFqJPU+2B+4UHbMnd2WVgloRvKF
42yTmmhLX+/iFF7bo100Y9nds9WZd7ueYdM8e3xlfxsaAM0qTmd1eWVuIFZhbiBOZ3V5ZW4gPG5n
dXllbm52MTk4MUBnbWFpbC5jb20+wsBABhAcCgAAAF8FAmbzftgiIQajZpX32QU9YiluDfY6DUi6
J3MNnD1PcbgqWMinyQ/qIAkQo2aV99kFPWICGwMDCwcJBCIBAgMFFQgMCg4FFgABAgMCHgsNJwcB
CQEHAgkCBwMJAwIZAQAAAABgWCAyhNd2vP10QOYnK1iKdYewmPtPOyNP/y/iKOe0plKKeC2D5rEH
XJGLr0nsx9gJa85GPJG8vzKbrjYkLkzaQj3aKskW796RqslR9o4McmVjH3fkmjukK2CEABLYAzFs
kNSSvtZPvT574FN21frEWF7K5pu8GslClN+2AL6109MMArgPMcAhEWVBy3Hgd6h57zk/AM0sTmd1
eWVuIFZhbiBOZ3V5ZW4gPG5ndXllbm52QGl3YXl2aWV0bmFtLmNvbT7CwD0GEBwKAAAAXAUCZvN+
2CIhBqNmlffZBT1iKW4N9joNSLoncw2cPU9xuCpYyKfJD+ogCRCjZpX32QU9YgIbAwMLBwkEIgEC
AwUVCAwKDgUWAAECAwIeCw0nBwEJAQcCCQIHAwkDAAAAAPFWIAJ2Cs6NuGo1flcRWegIsTzYN3/u
G3DIXNuRxLAirLsYWpS3gn7a0aS1GARGaJGJiaIuREYJjHpo20JLEQzj0HKKXoSg42JY9ExaGrRP
yVL2hgjWAD4D1aGACFW1Ij/C0YcoPaOcAkz0K6HCDuAi3Xk8JBvt7tIIRGhJiJG/2WCinMRe1S52
lyVKlnqqekfQtykAx60GZvN+1xoAAAA4toeLSE1P+jKskZLQ9QfTOJ2q0/36nw6KcoLzJlout9+r
u/aZQcnbAxTHM6pPol9NmVsfWk4HYrj+HQcLAwgbbgPlGehL+uCaJnK8VYk+uRjvEZkC2MUJm+wI
OewG+h8IsGSxSh8ua6+owE6rZjmXA/UpDqLiR3Jvy9vxg8QQmVlUZbh+Ztta6I1YmrfGMVCUGc69
TKl7KpcignYL99Lz5W3xL8LAFwYYHAoAAAA2BQJm837YIiEGo2aV99kFPWIpbg32Og1IuidzDZw9
T3G4KljIp8kP6iAJEKNmlffZBT1iAhsMAAAAAOvKIJ7+IJ4dztxkR2rRmf5DphiMHDJ+lSXr+Svs
qbDWAvsfIsNeKdP88/5gc94Dxh10xPSaS82akzoJ7RHMQ74zGIwexOlKRoBa9qLeDmkbO8rTE77m
3ngJsSoA2EqaRkPmjChELp6nGWPCZPyOa7ExcBkKrjiq8xMsnvjWdVsZ0BL8b93ER626rRzE9j5C
nWWFLDsA1Ri3Rbu551qo3Xk4o5gVhSC0J+7ZMZyQq2g=
=YGCQ
-----END PGP PRIVATE KEY BLOCK-----
EOT;
echo "Decrypt Curve448 private key" . PHP_EOL;
$privateKey = OpenPGP::decryptPrivateKey($keyData, $passphase);
echo "Key algorithm: {$privateKey->getKeyAlgorithm()->name}" . PHP_EOL;
echo "Key version: {$privateKey->getVersion()}" . PHP_EOL;
echo "Key fingerprint: {$privateKey->getFingerprint(true)}" . PHP_EOL;
echo "Key is decrypted: {$privateKey->isDecrypted()}" . PHP_EOL;
echo "User ID: {$privateKey->getPrimaryUser()->getUserID()}" .
    PHP_EOL .
    PHP_EOL;
