<?php

declare(strict_types=1);

/*
 * This file is part of the slince/china package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace China\IDCard;

/**
 * 算法摘自
 * {@link https://www.cnblogs.com/bossikill/p/3679926.html}.
 */
final class IDCardUtils
{
    /**
     * 计算身份证最后一位.
     *
     * @param string $idCardBody
     *
     * @return bool|string
     */
    public static function calcIDCardCode(string $idCardBody)
    {
        if (strlen($idCardBody) != 17) {
            return false;
        }
        //加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        //校验码对应值
        $code = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        $checksum = 0;

        for ($i = 0; $i < strlen($idCardBody); ++$i) {
            $checksum += substr($idCardBody, $i, 1) * $factor[$i];
        }

        return $code[$checksum % 11];
    }

    /**
     * 将15位身份证升级到18位.
     *
     * @param string $id
     *
     * @return bool|string
     */
    public static function convertIDCard15to18(string $id)
    {
        if (strlen($id) != 15) {
            return false;
        } else {
            // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
            if (array_search(substr($id, 12, 3), array('996', '997', '998', '999')) !== false) {
                $id = substr($id, 0, 6).'18'.substr($id, 6, 9);
            } else {
                $id = substr($id, 0, 6).'19'.substr($id, 6, 9);
            }
        }

        return $id . self::calcIDCardCode($id);
    }

    /**
     * 18位身份证校验码有效性检查.
     *
     * @param string $idCard
     *
     * @return bool
     */
    public static function check18IDCard(string $idCard): bool
    {
        if (strlen($idCard) != 18) {
            return false;
        }
        $idCardBody = substr($idCard, 0, 17); //身份证主体
        $idCardCode = strtoupper(substr($idCard, 17, 1)); //身份证最后一位的验证码

        return self::calcIDCardCode($idCardBody) === $idCardCode;
    }
}