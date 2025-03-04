import{_ as o,M as t,p as i,q as p,R as a,t as n,N as c,a1 as e}from"./framework-efe98465.js";const l={},r=e(`<h1 id="how-to-use" tabindex="-1"><a class="header-anchor" href="#how-to-use" aria-hidden="true">#</a> How to use</h1><h2 id="prerequisite" tabindex="-1"><a class="header-anchor" href="#prerequisite" aria-hidden="true">#</a> Prerequisite</h2><p>You are either working inside a regular Laravel Application or inside a <a href="../../core">Athenaeum Core Application</a>.</p><h2 id="example" tabindex="-1"><a class="header-anchor" href="#example" aria-hidden="true">#</a> Example</h2><p>Imagine that you have a component that depends on Laravel&#39;s configuration <code>Repository</code>. To obtain the bound instance, use the <code>ConfigTrait</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Support<span class="token punctuation">\\</span>Helpers<span class="token punctuation">\\</span>Config<span class="token punctuation">\\</span>ConfigTrait</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">Box</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">ConfigTrait</span><span class="token punctuation">;</span>
    
    <span class="token comment">// ... remaining not shown ... //</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,6),d=a("em",null,[a("code",null,"getConfig()")],-1),u=a("code",null,"Repository",-1),h={href:"https://laravel.com/docs/8.x/container",target:"_blank",rel:"noopener noreferrer"},k=e(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$box</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">Box</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$config</span> <span class="token operator">=</span> <span class="token variable">$box</span><span class="token operator">-&gt;</span><span class="token function">getConfig</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>You can also specify a custom <code>Repository</code>, should you wish it.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$box</span><span class="token operator">-&gt;</span><span class="token function">setConfig</span><span class="token punctuation">(</span><span class="token variable">$myCustomRepository</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div>`,3);function v(m,b){const s=t("ExternalLinkIcon");return i(),p("div",null,[r,a("p",null,[n("As soon as you invoke the getter method ("),d,n("), a local reference to the bound "),u,n(" is obtained from the "),a("a",h,[n("Service Container"),c(s)]),n(".")]),k])}const f=o(l,[["render",v],["__file","index.html.vue"]]);export{f as default};
