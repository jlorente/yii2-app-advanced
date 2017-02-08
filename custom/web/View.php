<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace custom\web;

use yii\web\View as BaseView;
use yii\helpers\Url;

/**
 * Custom implementation for yii\web\View
 *
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 */
class View extends BaseView {

    public $locale;
    public $siteName;
    public $description;
    public $type;
    protected $ogImages = [];
    protected $twitter;

    public function init() {
        parent::init();

        $this->on(self::EVENT_END_BODY, $this->getOgMetaTagsLoader());
        $this->on(self::EVENT_END_BODY, $this->getTwitterMetaTagsLoader());
    }

    protected function getOgMetaTagsLoader() {
        return function($event) {
            if ($this->locale !== null) {
                $locales = (array) $this->locale;
                $this->registerMetaTag([
                    'property' => 'og:locale',
                    'content' => array_shift($locales)
                ]);

                foreach ($locales as $locale) {
                    $this->registerMetaTag([
                        'property' => 'og:locale:alternate',
                        'content' => $locale
                    ]);
                }
            }
            $this->registerMetaTag([
                'property' => 'og:url',
                'content' => Url::current([], true)
            ]);
            if ($this->siteName !== null) {
                $this->registerMetaTag([
                    'property' => 'og:site_name',
                    'content' => $this->siteName
                ]);
            }
            if ($this->title !== null) {
                $this->registerMetaTag([
                    'property' => 'og:title',
                    'content' => $this->title
                ]);
            }

            if ($this->description !== null) {
                $this->registerMetaTag([
                    'property' => 'og:description',
                    'content' => $this->description
                ]);
            }
            if ($this->type !== null) {
                $this->registerMetaTag([
                    'property' => 'og:type',
                    'content' => $this->type
                ]);
            }
            if (empty($this->ogImages) === false) {
                foreach ($this->ogImages as $ogImage) {
                    $this->registerMetaTag([
                        'property' => 'og:image',
                        'content' => $ogImage['src']
                    ]);

                    if (isset($ogImage['width'])) {
                        $this->registerMetaTag([
                            'property' => 'og:image:width',
                            'content' => $ogImage['width']
                        ]);
                    }


                    if (isset($ogImage['height'])) {
                        $this->registerMetaTag([
                            'property' => 'og:image:height',
                            'content' => $ogImage['height']
                        ]);
                    }

                    if (isset($ogImage['type'])) {
                        $this->registerMetaTag([
                            'property' => 'og:image:type',
                            'content' => $ogImage['type']
                        ]);
                    }
                }
            }
        };
    }

    public function addOgImage($src, $width, $height) {
        $this->ogImages[] = [
            'src' => $src,
            'width' => $width,
            'height' => $height
        ];
    }

    protected function getTwitterMetaTagsLoader() {
        return function($event) {
            if (empty($this->twitter) === false) {
                if (isset($this->twitter['card'])) {
                    $this->registerMetaTag([
                        'name' => 'twitter:card',
                        'content' => $this->twitter['card']
                    ]);
                }

                if (isset($this->twitter['site'])) {
                    $this->registerMetaTag([
                        'name' => 'twitter:site',
                        'content' => $this->twitter['site']
                    ]);
                }

                if (isset($this->twitter['creator'])) {
                    $this->registerMetaTag([
                        'name' => 'twitter:creator',
                        'content' => $this->twitter['creator']
                    ]);
                }

                if ($this->title !== null) {
                    $this->registerMetaTag([
                        'name' => 'twitter:title',
                        'content' => $this->title
                    ]);
                }
                if ($this->description !== null) {
                    $this->registerMetaTag([
                        'property' => 'twitter:description',
                        'content' => $this->description
                    ]);
                }
                if (isset($this->twitter['image:src'])) {
                    $this->registerMetaTag([
                        'name' => 'twitter:image:src',
                        'content' => $this->twitter['image:src']
                    ]);
                }
            }
        };
    }

}
