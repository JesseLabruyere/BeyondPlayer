<?php

/* default/index.html.twig */
class __TwigTemplate_8091f7634817430a818c3f29041586d729a617dba4ab4c8dbf1a4cbd9ba282e8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "default/index.html.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_body($context, array $blocks = array())
    {
        // line 3
        echo "    <div class=\"container-fluid noPadding\" id=\"mainContainer\">
        <div class=\"row-fluid header-row\">
            <div class=\"col-md-12 noPadding header\" style=\"background-color:#d558d3;\">
                <!-- this file contains the header html -->
                ";
        // line 7
        $this->loadTemplate("default/index.html.twig", "default/index.html.twig", 7, "35310743")->display($context);
        // line 9
        echo "            </div>
        </div>
        <div class=\"row-fluid center-row\">
            <div class=\"col-md-2 leftbar\" style=\"background-color:#31b0d5;\">
                <!-- this file contains the leftbar -->
                ";
        // line 14
        $this->loadTemplate("default/index.html.twig", "default/index.html.twig", 14, "1938955931")->display($context);
        // line 16
        echo "            </div>
            <div class=\"col-md-10 center\" style=\"background-color:#f0ad4e;\">
                <!-- this file contains the center -->
                ";
        // line 19
        $this->loadTemplate("default/index.html.twig", "default/index.html.twig", 19, "306740352")->display($context);
        // line 21
        echo "            </div>
        </div>
        <div class=\"row-fluid footer-row\">
            <div class=\"col-md-12 footer\" style=\"background-color:#419641\">
                <!-- this file contains the footer -->
                ";
        // line 26
        $this->loadTemplate("default/index.html.twig", "default/index.html.twig", 26, "330414490")->display($context);
        // line 28
        echo "            </div>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "default/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  64 => 28,  62 => 26,  55 => 21,  53 => 19,  48 => 16,  46 => 14,  39 => 9,  37 => 7,  31 => 3,  28 => 2,  11 => 1,);
    }
}


/* default/index.html.twig */
class __TwigTemplate_8091f7634817430a818c3f29041586d729a617dba4ab4c8dbf1a4cbd9ba282e8_35310743 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 7
        $this->parent = $this->loadTemplate("header.html.twig", "default/index.html.twig", 7);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "header.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "default/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  95 => 7,  64 => 28,  62 => 26,  55 => 21,  53 => 19,  48 => 16,  46 => 14,  39 => 9,  37 => 7,  31 => 3,  28 => 2,  11 => 1,);
    }
}


/* default/index.html.twig */
class __TwigTemplate_8091f7634817430a818c3f29041586d729a617dba4ab4c8dbf1a4cbd9ba282e8_1938955931 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 14
        $this->parent = $this->loadTemplate("leftbar.html.twig", "default/index.html.twig", 14);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "leftbar.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "default/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  135 => 14,  95 => 7,  64 => 28,  62 => 26,  55 => 21,  53 => 19,  48 => 16,  46 => 14,  39 => 9,  37 => 7,  31 => 3,  28 => 2,  11 => 1,);
    }
}


/* default/index.html.twig */
class __TwigTemplate_8091f7634817430a818c3f29041586d729a617dba4ab4c8dbf1a4cbd9ba282e8_306740352 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 19
        $this->parent = $this->loadTemplate("center.html.twig", "default/index.html.twig", 19);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "center.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "default/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  175 => 19,  135 => 14,  95 => 7,  64 => 28,  62 => 26,  55 => 21,  53 => 19,  48 => 16,  46 => 14,  39 => 9,  37 => 7,  31 => 3,  28 => 2,  11 => 1,);
    }
}


/* default/index.html.twig */
class __TwigTemplate_8091f7634817430a818c3f29041586d729a617dba4ab4c8dbf1a4cbd9ba282e8_330414490 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 26
        $this->parent = $this->loadTemplate("footer.html.twig", "default/index.html.twig", 26);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "footer.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "default/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  215 => 26,  175 => 19,  135 => 14,  95 => 7,  64 => 28,  62 => 26,  55 => 21,  53 => 19,  48 => 16,  46 => 14,  39 => 9,  37 => 7,  31 => 3,  28 => 2,  11 => 1,);
    }
}
