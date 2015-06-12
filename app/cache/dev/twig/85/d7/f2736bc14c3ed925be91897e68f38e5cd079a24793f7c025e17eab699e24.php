<?php

/* footer.html.twig */
class __TwigTemplate_85d7f2736bc14c3ed925be91897e68f38e5cd079a24793f7c025e17eab699e24 extends Twig_Template
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
</html>
";
    }

    // line 4
    public function block_body($context, array $blocks = array())
    {
        // line 5
        echo "        <p>this is the footer!</p>
        ";
    }

    public function getTemplateName()
    {
        return "footer.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  36 => 5,  33 => 4,  27 => 7,  25 => 4,  20 => 1,);
    }
}
