<?php

/* center.html.twig */
class __TwigTemplate_15575adfae551c297c8812711af80187c764899c5e2ac2829a70fd891e934f52 extends Twig_Template
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
        echo "        <p>this is the center!</p>
        ";
    }

    public function getTemplateName()
    {
        return "center.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  35 => 5,  32 => 4,  27 => 7,  25 => 4,  20 => 1,);
    }
}
