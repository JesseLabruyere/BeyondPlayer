<?php

/* leftbar.html.twig */
class __TwigTemplate_50ca17a4b230ec90936d7b807407443eb702a18b6a54f567a8ab7a29b2090561 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <body>
        ";
        // line 4
        $this->displayBlock('body', $context, $blocks);
        // line 7
        echo "    </body>
</html>";
    }

    // line 4
    public function block_body($context, array $blocks = array())
    {
        // line 5
        echo "        <p>this is the left bar!</p>
        ";
    }

    public function getTemplateName()
    {
        return "leftbar.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  35 => 5,  32 => 4,  27 => 7,  25 => 4,  20 => 1,);
    }
}
