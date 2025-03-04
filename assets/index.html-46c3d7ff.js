import{_ as r,M as a,p as o,q as l,R as e,t as n,N as s,U as c,a1 as d}from"./framework-efe98465.js";const p={},u=e("h1",{id:"introduction",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#introduction","aria-hidden":"true"},"#"),n(" Introduction")],-1),v={href:"https://laravel.com/docs/11.x/localization",target:"_blank",rel:"noopener noreferrer"},m=e("h2",{id:"exporters",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#exporters","aria-hidden":"true"},"#"),n(" Exporters")],-1),h=d(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$translations</span> <span class="token operator">=</span> <span class="token variable">$exporter</span><span class="token operator">-&gt;</span><span class="token function">export</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;en&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;auth&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

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
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,2);function b(_,g){const t=a("ExternalLinkIcon"),i=a("RouterLink");return o(),l("div",null,[u,e("p",null,[n("The translation package contains a few utilities for "),e("a",v,[n("Laravel's Localization utilities"),s(t)]),n(".")]),m,e("p",null,[n("Among the available utilities are "),s(i,{to:"/archive/v8x/translation/exporters/"},{default:c(()=>[n("translation exporters")]),_:1}),n(".")]),h])}const k=r(p,[["render",b],["__file","index.html.vue"]]);export{k as default};
