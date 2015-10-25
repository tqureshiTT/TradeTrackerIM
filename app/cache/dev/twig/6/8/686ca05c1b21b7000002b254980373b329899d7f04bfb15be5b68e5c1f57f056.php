<?php

/* TwigBundle:Exception:exception_full.html.twig */
class __TwigTemplate_6e036463668c0052537cab6f8feff8ab3b2b94180f833b6ccb54374c192eb8be extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("TwigBundle::layout.html.twig", "TwigBundle:Exception:exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "TwigBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_43cc31f8f40171edd96696c5bce5f8eaa783dc76449fef6cd5f8b7d01f0a5030 = $this->env->getExtension("native_profiler");
        $__internal_43cc31f8f40171edd96696c5bce5f8eaa783dc76449fef6cd5f8b7d01f0a5030->enter($__internal_43cc31f8f40171edd96696c5bce5f8eaa783dc76449fef6cd5f8b7d01f0a5030_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_43cc31f8f40171edd96696c5bce5f8eaa783dc76449fef6cd5f8b7d01f0a5030->leave($__internal_43cc31f8f40171edd96696c5bce5f8eaa783dc76449fef6cd5f8b7d01f0a5030_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_ce11de8648331291e62bbe0751a19382db8252a26d269ab59a2faf8c70e0b3ed = $this->env->getExtension("native_profiler");
        $__internal_ce11de8648331291e62bbe0751a19382db8252a26d269ab59a2faf8c70e0b3ed->enter($__internal_ce11de8648331291e62bbe0751a19382db8252a26d269ab59a2faf8c70e0b3ed_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_ce11de8648331291e62bbe0751a19382db8252a26d269ab59a2faf8c70e0b3ed->leave($__internal_ce11de8648331291e62bbe0751a19382db8252a26d269ab59a2faf8c70e0b3ed_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_8f9efff3eb0c394eee3de8a2e96281c907a49fae9e0c6b1a9433b37c8509f1e2 = $this->env->getExtension("native_profiler");
        $__internal_8f9efff3eb0c394eee3de8a2e96281c907a49fae9e0c6b1a9433b37c8509f1e2->enter($__internal_8f9efff3eb0c394eee3de8a2e96281c907a49fae9e0c6b1a9433b37c8509f1e2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_8f9efff3eb0c394eee3de8a2e96281c907a49fae9e0c6b1a9433b37c8509f1e2->leave($__internal_8f9efff3eb0c394eee3de8a2e96281c907a49fae9e0c6b1a9433b37c8509f1e2_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_8845f91a505a3406f897a9e86e6accbd154f5de19c3e9734ff09ff1ce323b4ec = $this->env->getExtension("native_profiler");
        $__internal_8845f91a505a3406f897a9e86e6accbd154f5de19c3e9734ff09ff1ce323b4ec->enter($__internal_8845f91a505a3406f897a9e86e6accbd154f5de19c3e9734ff09ff1ce323b4ec_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("TwigBundle:Exception:exception.html.twig", "TwigBundle:Exception:exception_full.html.twig", 12)->display($context);
        
        $__internal_8845f91a505a3406f897a9e86e6accbd154f5de19c3e9734ff09ff1ce323b4ec->leave($__internal_8845f91a505a3406f897a9e86e6accbd154f5de19c3e9734ff09ff1ce323b4ec_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends 'TwigBundle::layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     <link href="{{ absolute_url(asset('bundles/framework/css/exception.css')) }}" rel="stylesheet" type="text/css" media="all" />*/
/* {% endblock %}*/
/* */
/* {% block title %}*/
/*     {{ exception.message }} ({{ status_code }} {{ status_text }})*/
/* {% endblock %}*/
/* */
/* {% block body %}*/
/*     {% include 'TwigBundle:Exception:exception.html.twig' %}*/
/* {% endblock %}*/
/* */
