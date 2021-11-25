<?php
namespace R3m\Io\Module\Compile;

/**
 * @copyright                (c) Remco van der Velde 2019 - 2021
 * @version                  0.1.45
 * @license                  MIT
 * @note                     Auto generated file, do not modify!
 * @author                   R3m\Io\Module\Parse\Build
 * @author                   Remco van der Velde
 * @parent                   /Application/Host/Cms/Funda/World/View/Settings/Body.tpl
 * @source                   /Application/Host/Cms/Funda/World/View/Settings/Section/Body/Main/Li/Account settings.tpl
 * @generation-date          2021-11-25 16:50:56
 * @generation-time          3.05 msec
 */

use Exception;
use stdClass;
use R3m\Io\App;
use R3m\Io\Config;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Filter;
use R3m\Io\Module\Handler;
use R3m\Io\Module\Host;
use R3m\Io\Module\Parse;
use R3m\Io\Module\Route;
use R3m\Io\Module\Sort;
use R3m\Io\Module\Template\Main;
use R3m\Io\Exception\AuthenticationException;
use R3m\Io\Exception\AuthorizationException;
use R3m\Io\Exception\ErrorException;
use R3m\Io\Exception\FileAppendException;
use R3m\Io\Exception\FileMoveException;
use R3m\Io\Exception\FileWriteException;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\ObjectException;
use R3m\Io\Exception\PluginNotFoundException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class Template_Body_Account_settings_76874c85b07c32dc1ae16cc176b74a4e8876e4ab extends Main {

        public function run(){
                ob_start();
                echo '<div
    class=';
                $string = 'accordion accordion-flush';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '
    id=';
                $string = 'accordion-flush-account-settings';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '
>
    <div class=';
                $string = 'accordion-item';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '>
        <h2
            class=';
                $string = 'accordion-header';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '
            id=';
                $string = 'flush-heading-one-account-settings';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '
        >
            <button
                class=';
                $string = 'accordion-button collapsed';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '
                type=';
                $string = 'button';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '
                data-bs-toggle=';
                $string = 'collapse';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '
                data-bs-target=';
                $string = '#flush-collapse-one-account-settings';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '
                aria-expanded=';
                $string = 'false';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '
                aria-controls=';
                $string = 'flush-collapse-one-account-settings';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '
            >
                ';
                $method = $this->function___($this->parse(), $this->storage(), 'settings.section.body.main.li.button.account_settings');
                if (is_object($method)){ return $method; }
                elseif (is_array($method)){ return $method; }
                else { echo $method; }
                echo '            </button>
        </h2>
        <div
            id=';
                $string = 'flush-collapse-one-account-settings';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '
            class=';
                $string = 'accordion-collapse collapse';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '
            aria-labelledby=';
                $string = 'flush-heading-one-account-setings';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '
            data-bs-parent=';
                $string = '#accordion-flush-account-settings';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '
        >
            <div class=';
                $string = 'accordion-body';
                $string = $this->parse()->compile($string, [], $this->storage());
                echo '"' . $string . '"';
                echo '>
                ';
                $method = $this->function___($this->parse(), $this->storage(), 'settings.section.body.main.li.body.account_settings');
                if (is_object($method)){ return $method; }
                elseif (is_array($method)){ return $method; }
                else { echo $method; }
                echo '            </div>
        </div>
    </div>
</div>';
                return ob_get_clean();
        }

        private function function___(Parse $parse, Data $data, $attribute=null){
            $object = $parse->object();
            $language = $object->session('language');
            if($language === null){
                $language = $object->session('language', $object->config('framework.default.language'));
            }
            $test = $object->data('translation');
            if(empty($test)){
                return '{import.translation()} missing or corrupted translation file...' . PHP_EOL;
            }
            $translation = $object->data('translation.' . $language);
            if(property_exists($translation, $attribute)){
                return $translation->{$attribute};
            } else {
                $translation = $object->data('translation.' . $object->config('framework.default.language'));
                if(property_exists($translation, $attribute)){
                    return $translation->{$attribute};
                } else {
                    return $attribute;
                }
            }
        }

// R3M-IO-c2787525-867b-45df-b7c0-fda120e8131d
}