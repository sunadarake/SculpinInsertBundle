<?php

namespace Darake\SculpinInsertBundle;

use Sculpin\Core\Sculpin;
use Sculpin\Core\Event\ConvertEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Dflydev\DotAccessConfiguration\ConfigurationInterface;

class PostInsertConverter implements EventSubscriberInterface
{
    protected $siteConfigration;

    public function __construct(ConfigurationInterface $siteConfigration, string $insertContent)
    {
        $this->siteConfigration = $siteConfigration;
        $this->insertContent = $insertContent;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Sculpin::EVENT_BEFORE_CONVERT => array('beforeRun', 100),
        ];
    }

    public function beforeRun(ConvertEvent $convertEvent): void
    {
        $source = $convertEvent->source();
        $data = $source->data();
        $export = $data->export();

        if ($data->get("layout") === "post") {
            if (array_key_exists("type", $export) && $export["type"] == "lp") return;

            $content = $source->content();
            $replace = $this->insertContent . "\n\n" . '${0}';
            $replaceContent = preg_replace("/(## +.+?\n)/", $replace, $content, 1);

            if ($replaceContent) {
                $source->setContent($replaceContent);
            }
        }
    }
}
