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
        // line 14
        echo "    </body>
</html>

<!-- verbatim tag zorgt ervoor dat de content die erin staat niet gerenderd wordt door de twig engine.
     Dit is belangrijk, omdat twig en angular dezelfde brackets gebruiken. (deze oplossing gekozen ipv de default angular
     waarde te wijzigen. Angular code staat in test1.js)
-->";
    }

    // line 4
    public function block_body($context, array $blocks = array())
    {
        // line 5
        echo "            ";
        // line 11
        echo "
            <div ng-app='app'>
                <div ng-controller=\"MyController\" ng-init=\"myVar = 'door angular gegenereerd'\">
                    {{myVar}}
                </div>
            </div>
            ";
        echo "
        <p>this is the footer!</p>
        ";
    }

    public function getTemplateName()
    {
        return "footer.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  42 => 11,  40 => 5,  37 => 4,  27 => 14,  25 => 4,  20 => 1,);
    }
}
