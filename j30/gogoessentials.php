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
    }

    public function onBeforeCompileHead()
    {
        if ($this->params->get('googleAnaliytics_admin') == false) {
            $app = JFactory::getApplication();

            if ($app->isAdmin()) {
                return;
            }
        }

        if($this->params->get('googleAnalytics_id'))
        $this->addingTrackingCode($this->params->get('googleAnalytics_id'));
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
