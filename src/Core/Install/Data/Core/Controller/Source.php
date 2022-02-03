<?php
/**
 * @author          Remco van der Velde
 * @since           04-01-2019
 * @copyright       (c) Remco van der Velde
 * @license         MIT
 * @version         1.0
 * @changeLog
 *  -    all
 */
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Module\View;
use R3m\Io\Module\Response;

use Host\Subdomain\Host\Extension\Service\Source as Service;

use Exception;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class Source extends View{
    const NAME = 'Source';
    const DIR = __DIR__;

    public static function to_li(App $object): Response
    {
        $read = $object->request('content');
        return Service::toLi($object, $read);
    }

}
