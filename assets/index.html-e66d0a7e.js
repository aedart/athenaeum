import{_ as i,M as t,p as c,q as r,R as a,t as n,N as s,U as l,a1 as o}from"./framework-efe98465.js";const u={},d=a("h1",{id:"introduction",tabindex:"-1"},[a("a",{class:"header-anchor",href:"#introduction","aria-hidden":"true"},"#"),n(" Introduction")],-1),k={href:"https://packagist.org/packages/illuminate/support",target:"_blank",rel:"noopener noreferrer"},v=a("h2",{id:"laravel-aware-of-helpers",tabindex:"-1"},[a("a",{class:"header-anchor",href:"#laravel-aware-of-helpers","aria-hidden":"true"},"#"),n(" Laravel Aware-of Helpers")],-1),h={href:"https://en.wikipedia.org/wiki/Mutator_method",target:"_blank",rel:"noopener noreferrer"},m=a("code",null,"Repository",-1),f={href:"https://laravel.com/docs/8.x/container",target:"_blank",rel:"noopener noreferrer"},g={href:"https://laravel.com/docs/8.x/facades",target:"_blank",rel:"noopener noreferrer"},_=o(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Support<span class="token punctuation">\\</span>Helpers<span class="token punctuation">\\</span>Config<span class="token punctuation">\\</span>ConfigTrait</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">MyApiService</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">ConfigTrait</span><span class="token punctuation">;</span>    

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">__construct</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$config</span> <span class="token operator">=</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">getConfig</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token variable">$url</span> <span class="token operator">=</span> <span class="token variable">$config</span><span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;services.trucks-api.url&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    
        <span class="token comment">// ... remaining not shown ...</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="aware-of-properties" tabindex="-1"><a class="header-anchor" href="#aware-of-properties" aria-hidden="true">#</a> Aware-of Properties</h2>`,2),b=a("a",{href:"../dto"},"DTOs",-1),w=o(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Support<span class="token punctuation">\\</span>Properties<span class="token punctuation">\\</span>Strings<span class="token punctuation">\\</span>NameTrait</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Support<span class="token punctuation">\\</span>Properties<span class="token punctuation">\\</span>Integers<span class="token punctuation">\\</span>AgeTrait</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">Person</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">NameTrait</span><span class="token punctuation">;</span>
    <span class="token keyword">use</span> <span class="token package">AgeTrait</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>  
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,1);function y(x,T){const e=t("ExternalLinkIcon"),p=t("RouterLink");return c(),r("div",null,[d,a("p",null,[n("Offers complementary components and helpers to "),a("a",k,[n("Laravel's Support package"),s(e)]),n(".")]),v,a("p",null,[n("Traits that offer "),a("a",h,[n("Getters and Setters"),s(e)]),n(" helpers for some of Laravel's core packages.")]),a("p",null,[n("These components allow you to manually set and retrieve a Laravel component, e.g. a configuration "),m,n(". Additionally, when no component instance has been specified, it will automatically default to whatever Laravel has bound in the "),a("a",f,[n("Service Container"),s(e)]),n(".")]),a("p",null,[n("You can think of these helpers as supplements, or alternatives to Laravel's native "),a("a",g,[n("Facades"),s(e)]),n(".")]),_,a("p",null,[n('In addition to the Laravel Aware-of Helpers, this package comes with an abundance of "aware-of xyz" helpers. These are '),s(p,{to:"/archive/v5x/support/properties/"},{default:l(()=>[n("generated")]),_:1}),n(" traits that offer getters and setter methods for various types properties. They are mostly useful when creating "),b,n(".")]),w])}const A=i(u,[["render",y],["__file","index.html.vue"]]);export{A as default};
