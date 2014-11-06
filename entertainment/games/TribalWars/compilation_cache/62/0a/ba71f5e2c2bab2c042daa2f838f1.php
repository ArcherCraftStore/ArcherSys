<?php

/* index.news.tpl */
class __TwigTemplate_620aba71f5e2c2bab2c042daa2f838f1 extends Twig_Template
{
    protected function doGetParent(array $context)
    {
        return false;
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "              ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["news"]) ? $context["news"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 2
            echo "              <span class=\"global-news\">&nbsp;</span>
              <strong>";
            // line 3
            echo twig_escape_filter($this->env, twig_date_format_filter($this->getAttribute((isset($context["row"]) ? $context["row"] : null), "newsDate"), "d.m.y H:i"), "html", null, true);
            echo "</strong>
              <p>
                ";
            // line 5
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["row"]) ? $context["row"] : null), "newsTitle"), "html", null, true);
            echo "
                <br />
                ";
            // line 7
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["row"]) ? $context["row"] : null), "newsDesc"), "html", null, true);
            echo "<br />
                <a href=\"";
            // line 8
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["row"]) ? $context["row"] : null), "newsLink"), "html", null, true);
            echo "\">&raquo; mehr</a>
              </p>
              <div class=\"news-separator\"></div>
              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
    }

    public function getTemplateName()
    {
        return "index.news.tpl";
    }

    public function isTraitable()
    {
        return false;
    }
}
