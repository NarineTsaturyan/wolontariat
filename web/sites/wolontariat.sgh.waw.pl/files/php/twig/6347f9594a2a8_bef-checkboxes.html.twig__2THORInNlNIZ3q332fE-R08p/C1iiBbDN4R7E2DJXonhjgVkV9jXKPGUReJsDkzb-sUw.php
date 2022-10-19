<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* modules/contrib/better_exposed_filters/templates/bef-checkboxes.html.twig */
class __TwigTemplate_e659f7a477c8bea8f8ec9e252af07ed9457d939532cabdeaff0ad0cfabe691ab extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 13
        $context["classes"] = [0 => "form-checkboxes", 1 => "bef-checkboxes", 2 => ((        // line 16
($context["is_nested"] ?? null)) ? ("bef-nested") : ("")), 3 => ((        // line 17
($context["show_select_all_none"] ?? null)) ? ("bef-select-all-none") : ("")), 4 => ((        // line 18
($context["show_select_all_none_nested"] ?? null)) ? ("bef-select-all-none-nested") : ("")), 5 => ((        // line 19
($context["display_inline"] ?? null)) ? ("form--inline") : (""))];
        // line 21
        echo "<div";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["wrapper_attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 21), 21, $this->source), "html", null, true);
        echo ">
  ";
        // line 22
        $context["current_nesting_level"] = 0;
        // line 23
        echo "  ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["children"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 24
            echo "    ";
            $context["item"] = twig_get_attribute($this->env, $this->source, ($context["element"] ?? null), $context["child"], [], "any", false, false, true, 24);
            // line 25
            echo "    ";
            if (($context["is_nested"] ?? null)) {
                // line 26
                echo "      ";
                $context["new_nesting_level"] = twig_get_attribute($this->env, $this->source, ($context["depth"] ?? null), $context["child"], [], "any", false, false, true, 26);
                // line 27
                echo "      ";
                $this->loadTemplate("@better_exposed_filters/bef-nested-elements.html.twig", "modules/contrib/better_exposed_filters/templates/bef-checkboxes.html.twig", 27)->display($context);
                // line 28
                echo "      ";
                $context["current_nesting_level"] = ($context["new_nesting_level"] ?? null);
                // line 29
                echo "    ";
            } else {
                // line 30
                echo "      ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["item"] ?? null), 30, $this->source), "html", null, true);
                echo "
    ";
            }
            // line 32
            echo "  ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 33
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "modules/contrib/better_exposed_filters/templates/bef-checkboxes.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  108 => 33,  94 => 32,  88 => 30,  85 => 29,  82 => 28,  79 => 27,  76 => 26,  73 => 25,  70 => 24,  52 => 23,  50 => 22,  45 => 21,  43 => 19,  42 => 18,  41 => 17,  40 => 16,  39 => 13,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/better_exposed_filters/templates/bef-checkboxes.html.twig", "/var/www/html/dpd-test.sgh.waw.pl/web/modules/contrib/better_exposed_filters/templates/bef-checkboxes.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 13, "for" => 23, "if" => 25, "include" => 27);
        static $filters = array("escape" => 21);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'for', 'if', 'include'],
                ['escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
