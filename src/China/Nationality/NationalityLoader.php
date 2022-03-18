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

namespace China\Nationality;

use China\Common\ResourceLoader\LazyLoader;

class NationalityLoader extends LazyLoader
{
    /**
     * {@inheritdoc}
     */
    public function handleRawData($data)
    {
        return array_map(function($data){
            return new Nationality($data['name'], $data['pinyin'], $data['population']);
        }, $data);
    }
}