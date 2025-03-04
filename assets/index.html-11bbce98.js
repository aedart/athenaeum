import{_ as e,M as t,p as o,q as p,R as s,t as n,N as i,a1 as c}from"./framework-efe98465.js";const l={},r=s("h1",{id:"streams",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#streams","aria-hidden":"true"},"#"),n(" Streams")],-1),d={href:"https://www.php-fig.org/psr/psr-7/#13-streams",target:"_blank",rel:"noopener noreferrer"},u=s("code",null,"StreamInterface",-1),k=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Streams<span class="token punctuation">\\</span>FileStream</span><span class="token punctuation">;</span>

<span class="token variable">$stream</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;my-file.txt&#39;</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">put</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;Hi there&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$more</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">openMemory</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">put</span><span class="token punctuation">(</span><span class="token string double-quoted-string">&quot;\\nMore things to show...&quot;</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">positionToStart</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$stream</span>
    <span class="token operator">-&gt;</span><span class="token function">append</span><span class="token punctuation">(</span><span class="token variable">$more</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token punctuation">(</span><span class="token keyword type-casting">string</span><span class="token punctuation">)</span> <span class="token variable">$stream</span><span class="token punctuation">;</span> <span class="token comment">// Hi there</span>
                       <span class="token comment">// More things to show...</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="motivation" tabindex="-1"><a class="header-anchor" href="#motivation" aria-hidden="true">#</a> Motivation</h2><p>There are many good alternatives to this package. Sadly, some of those alternatives makes it unreasonably difficult to extend their offered functionality. Therefore, while this package offers similar or identical functionality as some of those alternatives, it allows you (<em>and encourages you</em>) to extend the functionality that is provided by this package.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Streams<span class="token punctuation">\\</span>FileStream</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">TranscriptFileStream</span> <span class="token keyword">extends</span> <span class="token class-name">FileStream</span>
<span class="token punctuation">{</span>
    <span class="token comment">// ...your domain-specific logic here ...</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,4);function m(v,h){const a=t("ExternalLinkIcon");return o(),p("div",null,[r,s("p",null,[n('The "streams" package offers an extended version of '),s("a",d,[n("PSR-7's"),i(a)]),n(" defined "),u,n("; a wrapper for common stream operations, mostly intended for file streams.")]),k])}const g=e(l,[["render",m],["__file","index.html.vue"]]);export{g as default};
