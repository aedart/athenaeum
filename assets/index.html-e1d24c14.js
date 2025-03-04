import{_ as r,M as a,p as l,q as o,R as n,t as e,N as s,U as c,a1 as d}from"./framework-efe98465.js";const p={},u=n("h1",{id:"introduction",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#introduction","aria-hidden":"true"},"#"),e(" Introduction")],-1),v=n("p",null,[n("em",null,[n("strong",null,"Available since"),e(),n("code",null,"v7.3.x")])],-1),m={href:"https://laravel.com/docs/10.x/localization",target:"_blank",rel:"noopener noreferrer"},h=n("h2",{id:"exporters",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#exporters","aria-hidden":"true"},"#"),e(" Exporters")],-1),b=d(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$translations</span> <span class="token operator">=</span> <span class="token variable">$exporter</span><span class="token operator">-&gt;</span><span class="token function">export</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;en&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;auth&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token function">print_r</span><span class="token punctuation">(</span><span class="token variable">$translations</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><div class="language-text line-numbers-mode" data-ext="text"><pre class="language-text"><code>Array
(
    [en] =&gt; Array
        (
            [__JSON__] =&gt; Array
                (
                    [The :attribute must contain one letter.] =&gt; The :attribute must contain one letter.
                )
            [auth] =&gt; Array
                (
                    [failed] =&gt; These credentials do not match our records.
                    [password] =&gt; The provided password is incorrect.
                    [throttle] =&gt; Too many login attempts. Please try again in :seconds seconds.
                )
        )
)
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,2);function _(g,x){const t=a("ExternalLinkIcon"),i=a("RouterLink");return l(),o("div",null,[u,v,n("p",null,[e("The translation package contains a few utilities for "),n("a",m,[e("Laravel's Localization utilities"),s(t)]),e(".")]),h,n("p",null,[e("Among the available utilities are "),s(i,{to:"/archive/v7x/translation/exporters/"},{default:c(()=>[e("translation exporters")]),_:1}),e(".")]),b])}const f=r(p,[["render",_],["__file","index.html.vue"]]);export{f as default};
