import{_ as t,M as i,p as r,q as o,R as n,t as s,N as a,a1 as l}from"./framework-efe98465.js";const c={},d=n("h1",{id:"lang-js-array",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#lang-js-array","aria-hidden":"true"},"#"),s(" Lang.js (Array)")],-1),p=n("p",null,[n("strong",null,"Driver"),s(": "),n("code",null,"\\Aedart\\Translation\\Exports\\Drivers\\LangJsExporter")],-1),u={href:"https://github.com/rmariuzzo/Lang.js",target:"_blank",rel:"noopener noreferrer"},v={href:"https://github.com/rmariuzzo/Lang.js#messages-source-format",target:"_blank",rel:"noopener noreferrer"},m=l(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$translations</span> <span class="token operator">=</span> <span class="token variable">$manager</span>
    <span class="token operator">-&gt;</span><span class="token function">profile</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;array&#39;</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">export</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;en&#39;</span><span class="token punctuation">,</span> <span class="token punctuation">[</span> <span class="token string single-quoted-string">&#39;auth&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;acme::users&#39;</span> <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token function">print_r</span><span class="token punctuation">(</span><span class="token variable">$translations</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>The output format looks similar to the following:</p><div class="language-text line-numbers-mode" data-ext="text"><pre class="language-text"><code>Array
(
    [en.__JSON__] =&gt; Array
        (
            [ok] =&gt; Nice, mate!
        )
    [en.auth] =&gt; Array
        (
            [failed] =&gt; These credentials do not match our records.
            [password] =&gt; The provided password is incorrect.
            [throttle] =&gt; Too many login attempts. Please try again in :seconds seconds.
        )
    [en.translation-test::users] =&gt; Array
        (
            [greetings] =&gt; Comrades are the cannons of the weird halitosis.
            [messages] =&gt; Array
                (
                    [a] =&gt; Spacecrafts meet with ellipse!
                    [b] =&gt; Uniqueness is the only samadhi, the only guarantee of solitude.
                    [c] =&gt; Ho-ho-ho! punishment of beauty.
                )
        )
)
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,3);function g(h,b){const e=i("ExternalLinkIcon");return r(),o("div",null,[d,p,n("p",null,[s("If you are using "),n("a",u,[s("lang.js"),a(e)]),s(", then you can use this exporter to create an array, that is formatted according to the "),n("a",v,[s("desired message format"),a(e)]),s(".")]),m])}const _=t(c,[["render",g],["__file","lang-js.html.vue"]]);export{_ as default};
