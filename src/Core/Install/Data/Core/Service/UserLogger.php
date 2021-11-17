<?php
namespace Host\Subdomain\Host\Extension\Service;


use DateTime;
use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\File;

use R3m\Io\Exception\ObjectException;

class UserLogger extends Main {
    const STATUS_BLOCKED = 'blocked';
    const STATUS_SUCCESS = 'success';
    const STATUS_INVALID_PASSWORD = 'invalid-password';
    const STATUS_INVALID_EMAIL = 'invalid-email';

    const LOGIN_PERIOD = '-15 Minutes';

    public static function log(App $object, $user=null, $status=null){
        $url = UserLogger::getDataUrl($object);
        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        $uuid = Core::uuid();
        if(array_key_exists('REMOTE_ADDR', $_SERVER)){
            $data->set($uuid . '.ipAddress', $_SERVER['REMOTE_ADDR']);
        } else {
            $data->set($uuid . '.ipAddress', '0.0.0.0');
        }
        $data->set($uuid . '.dateTime', new dateTime());
        if(
            $user !== null
        ){
            $data->set($uuid . '.user.uuid', $user->uuid);
        }
        $data->set($uuid . '.status', $status);
        $data->write($url);
    }

    public static function count(App $object, $user=null, $status=null){
        if(
            $user !== null &&
            property_exists($user, 'uuid')
        ) {
            $counter = 0;
            $dateTime = date('Y-m-d H:i:s', strtotime(UserLogger::LOGIN_PERIOD));
            $url = UserLogger::getDataUrl($object);
            $data = $object->data_read($url);
            if (!$data) {
                return $counter;
            }
            foreach ($data->data() as $uuid => $log) {
                if (
                    property_exists($log, 'user') &&
                    property_exists($log, 'dateTime') &&
                    property_exists($log->dateTime, 'date') &&
                    property_exists($log->user, 'uuid') &&
                    $log->user->uuid === $user->uuid &&
                    property_exists($log, 'status') &&
                    $log->status === $status &&
                    $log->dateTime->date >= $dateTime
                ) {
                    $counter++;
                }
            }
            return $counter;
        }



            /*
            $options = [];
            $entityManager = Database::entityManager($object, $options);
            $user_id = $user->getId();

            $query = 'SELECT l 
                FROM ' .
                __CLASS__ . ' l 
                WHERE l.user_id LIKE :user_id  AND 
                l.status = :status AND 
                l.dateTime >= :dateTime';

            $result = $entityManager->createQuery($query)
                ->setParameter('user_id', $user_id)
                ->setParameter('status', $status)
                ->setParameter('dateTime', $dateTime)
                ->getResult();
            return count($result);
        } else {
            $options = [];
            $entityManager = Database::entityManager($object, $options);
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $dateTime = date('Y-m-d H:i:s', strtotime(Logger::LOGIN_PERIOD));
            $query = 'SELECT l 
                FROM ' .
                __CLASS__ . ' l 
                WHERE l.user_id IS NULL AND
                l.ipAddress = :ipAddress AND 
                l.status = :status AND 
                l.dateTime >= :dateTime';

            $result = $entityManager->createQuery($query)
                ->setParameter('ipAddress', $ipAddress)
                ->setParameter('status', $status)
                ->setParameter('dateTime', $dateTime)
                ->getResult();
            return count($result);
        }
        */
    }

    private static function getDataUrl(App $object): string
    {
        return $object->config('host.dir.root') .
            'Node' .
            $object->config('ds') .
            'List' .
            $object->config('ds') .
            File::basename(__CLASS__) .
            $object->config('extension.json');
    }


    
}
