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
            'title' => array($this, 'block_title'),
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

    // line 4
    public function block_title($context, array $blocks = array())
    {
        echo " test ";
    }

    // line 6
    public function block_body($context, array $blocks = array())
    {
        // line 7
        echo "    <div class=\"container-fluid noPadding\" id=\"mainContainer\">
        <div class=\"row-fluid\">
            <div class=\"col-md-12 noPadding\">
                <!-- this file contains the header html -->
                ";
        // line 11
        $this->loadTemplate("default/index.html.twig", "default/index.html.twig", 11, "49163843")->display($context);
        // line 13
        echo "            </div>
        </div>
        <div class=\"row-fluid\">
            <div class=\"col-md-2\" style=\"background-color:#31b0d5;\">
                <!-- this file contains the leftbar -->
                ";
        // line 18
        $this->loadTemplate("default/index.html.twig", "default/index.html.twig", 18, "1775640474")->display($context);
        // line 20
        echo "            </div>
            <div class=\"col-md-10\" style=\"background-color:#f0ad4e;\">
                <!-- this file contains the center -->
                ";
        // line 23
        $this->loadTemplate("default/index.html.twig", "default/index.html.twig", 23, "1746334428")->display($context);
        // line 25
        echo "            </div>
        </div>
        <div class=\"row-fluid\">
            <div class=\"col-md-12\" style=\"background-color:#419641\">
                <!-- this file contains the footer -->
                ";
        // line 30
        $this->loadTemplate("default/index.html.twig", "default/index.html.twig", 30, "1272784893")->display($context);
        // line 32
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
        return array (  71 => 32,  69 => 30,  62 => 25,  60 => 23,  55 => 20,  53 => 18,  46 => 13,  44 => 11,  38 => 7,  35 => 6,  29 => 4,  11 => 1,);
    }
}


/* default/index.html.twig */
class __TwigTemplate_8091f7634817430a818c3f29041586d729a617dba4ab4c8dbf1a4cbd9ba282e8_49163843 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 11
        $this->parent = $this->loadTemplate("header.html.twig", "default/index.html.twig", 11);
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
        return array (  102 => 11,  71 => 32,  69 => 30,  62 => 25,  60 => 23,  55 => 20,  53 => 18,  46 => 13,  44 => 11,  38 => 7,  35 => 6,  29 => 4,  11 => 1,);
    }
}


/* default/index.html.twig */
class __TwigTemplate_8091f7634817430a818c3f29041586d729a617dba4ab4c8dbf1a4cbd9ba282e8_1775640474 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 18
        $this->parent = $this->loadTemplate("leftbar.html.twig", "default/index.html.twig", 18);
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
        return array (  142 => 18,  102 => 11,  71 => 32,  69 => 30,  62 => 25,  60 => 23,  55 => 20,  53 => 18,  46 => 13,  44 => 11,  38 => 7,  35 => 6,  29 => 4,  11 => 1,);
    }
}


/* default/index.html.twig */
class __TwigTemplate_8091f7634817430a818c3f29041586d729a617dba4ab4c8dbf1a4cbd9ba282e8_1746334428 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 23
        $this->parent = $this->loadTemplate("center.html.twig", "default/index.html.twig", 23);
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
        return array (  182 => 23,  142 => 18,  102 => 11,  71 => 32,  69 => 30,  62 => 25,  60 => 23,  55 => 20,  53 => 18,  46 => 13,  44 => 11,  38 => 7,  35 => 6,  29 => 4,  11 => 1,);
    }
}


/* default/index.html.twig */
class __TwigTemplate_8091f7634817430a818c3f29041586d729a617dba4ab4c8dbf1a4cbd9ba282e8_1272784893 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 30
        $this->parent = $this->loadTemplate("footer.html.twig", "default/index.html.twig", 30);
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
        return array (  222 => 30,  182 => 23,  142 => 18,  102 => 11,  71 => 32,  69 => 30,  62 => 25,  60 => 23,  55 => 20,  53 => 18,  46 => 13,  44 => 11,  38 => 7,  35 => 6,  29 => 4,  11 => 1,);
    }
}
