import{_ as e,M as t,p as o,q as c,R as n,t as s,N as p,a1 as i}from"./framework-efe98465.js";const l={},r=n("h1",{id:"destroy",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#destroy","aria-hidden":"true"},"#"),s(),n("code",null,"destroy()")],-1),d={href:"https://laravel.com/docs/7.x/facades",target:"_blank",rel:"noopener noreferrer"},u=n("code",null,"Facade",-1),k=n("code",null,"Facade",-1),h=i(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Container<span class="token punctuation">\\</span>IoC</span><span class="token punctuation">;</span>

<span class="token variable">$ioc</span> <span class="token operator">=</span> <span class="token class-name static-context">IoC</span><span class="token operator">::</span><span class="token function">getInstance</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// ...later in your application or test</span>
<span class="token variable">$ioc</span><span class="token operator">-&gt;</span><span class="token function">destroy</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,1);function _(v,m){const a=t("ExternalLinkIcon");return o(),c("div",null,[r,n("p",null,[s("This method ensures that all bindings are unset, including those located within the "),n("a",d,[u,p(a)]),s(". In addition, when invoked the "),k,s("'s application is also unset.")]),h])}const f=e(l,[["render",_],["__file","destroy.html.vue"]]);export{f as default};
