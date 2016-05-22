<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @email info@gogodigital.it
 * @github https://github.com/cinghie/joomla-gogo-essentials
 * @license GNU GENERAL PUBLIC LICENSE VERSION 2
 * @package Joomla Gogodigital Essentials
 * @version 3.0.0
 */

// no direct access
defined( '_JEXEC' ) or die;

class plgSystemGogoessentials extends JPlugin
{

    public function __construct( &$subject, $config )
    {
        parent::__construct( $subject, $config );
        $this->admin_key = $this->params->get('adminKey');
    }

    public function onAfterDispatch()
    {
        $app = JFactory::getApplication();

        if($this->admin_key)
        {
            if ($app->isAdmin() && !isset($_GET[$this->admin_key]))
            {
                $app->redirect(JURI::root());
            }
        }
    }

    public function onAfterInitialise()
    {
        $document = JFactory::getDocument();

        if(!empty($this->params->get('alexaVerification'))) { $document->setMetaData('alexaVerifyID', $this->params->get('alexaVerification')); }
        if(!empty($this->params->get('bingVerification'))) { $document->setMetaData('msvalidate.01', $this->params->get('bingVerification')); }
        if(!empty($this->params->get('googleVerification'))) { $document->setMetaData('google-site-verification', $this->params->get('googleVerification')); }
        if(!empty($this->params->get('nortonVerification'))) { $document->setMetaData('norton-safeweb-site-verification', $this->params->get('nortonVerification')); }
        if(!empty($this->params->get('pinterestVerification'))) { $document->setMetaData('p:domain_verify', $this->params->get('pinterestVerification')); }
        if(!empty($this->params->get('yandexVerification'))) { $document->setMetaData('yandex-verification', $this->params->get('yandexVerification')); }
    }

    public function onBeforeCompileHead()
    {
        if (!$this->params->get('googleAnalyticsAdmin'))
        {
            $app = JFactory::getApplication();

            if ($app->isAdmin()) {
                return;
            }
        }

        if($this->params->get('googleAnalyticsID'))
        $this->addingTrackingCode($this->params->get('googleAnalyticsID'));
    }

    protected function addingTrackingCode($trackingid)
    {
        $script = "\n\t"."(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){";
        $script.= "\n\t"."(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),";
        $script.= "\n\t"."m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)";
        $script.= "\n\t"."})(window,document,'script','//www.google-analytics.com/analytics.js','ga');";
        $script.= "\n\t"."ga('create', '".$trackingid."', 'auto');";
        $script.= "\n\t"."ga('send', 'pageview');";

        $document = JFactory::getDocument();
        $document->addScriptDeclaration($script);
    }

}
