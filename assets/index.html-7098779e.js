import{_ as i,M as p,p as l,q as r,R as n,t as s,N as a,U as o,a1 as c}from"./framework-efe98465.js";const u={},d=n("h1",{id:"introduction",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#introduction","aria-hidden":"true"},"#"),s(" Introduction")],-1),k=n("em",null,"[...] A resource class represents a single model that needs to be transformed into a JSON structure [...]",-1),v={href:"https://laravel.com/docs/9.x/eloquent-resources#concept-overview",target:"_blank",rel:"noopener noreferrer"},m=n("code",null,"ApiResource",-1),b={href:"https://laravel.com/docs/9.x/eloquent-resources#concept-overview",target:"_blank",rel:"noopener noreferrer"},g=n("code",null,"JsonResource",-1),h=c(`<h3 id="how-to-create-an-api-resource" tabindex="-1"><a class="header-anchor" href="#how-to-create-an-api-resource" aria-hidden="true">#</a> How to create an Api Resource</h3><p>Extend the <code>ApiResource</code> and implement the <code>formatPayload()</code> and <code>type()</code> methods.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Api<span class="token punctuation">\\</span>Resources<span class="token punctuation">\\</span>ApiResource</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Request</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>Address</span><span class="token punctuation">;</span>

<span class="token doc-comment comment">/**
 * <span class="token keyword">@mixin</span> Address
 */</span>
<span class="token keyword">class</span> <span class="token class-name-definition class-name">AddressResource</span> <span class="token keyword">extends</span> <span class="token class-name">ApiResource</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">formatPayload</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Request</span> <span class="token variable">$request</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;id&#39;</span> <span class="token operator">=&gt;</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">id</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;street&#39;</span> <span class="token operator">=&gt;</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">street</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;postal_code&#39;</span> <span class="token operator">=&gt;</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">postal_code</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;city&#39;</span> <span class="token operator">=&gt;</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">city</span>
        <span class="token punctuation">]</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">type</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">string</span>
    <span class="token punctuation">{</span>
        <span class="token comment">// Resource&#39;s type name (singular form)</span>
        <span class="token keyword">return</span> <span class="token string single-quoted-string">&#39;address&#39;</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="register-api-resource" tabindex="-1"><a class="header-anchor" href="#register-api-resource" aria-hidden="true">#</a> Register Api Resource</h2>`,4),y=n("code",null,"config/api-resources.php",-1),f=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>Address</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Resources<span class="token punctuation">\\</span>AddressResource</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">/*
     |--------------------------------------------------------------------------
     | Api Resources
     |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;registry&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token class-name static-context">Address</span><span class="token operator">::</span><span class="token keyword">class</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">AddressResource</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>

    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="usage" tabindex="-1"><a class="header-anchor" href="#usage" aria-hidden="true">#</a> Usage</h2><p>After your Api Resource has been registered, you can use it as you normally would with Laravel&#39;s <code>JsonResource</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Support<span class="token punctuation">\\</span>Facades<span class="token punctuation">\\</span>Route</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Resources<span class="token punctuation">\\</span>AddressResource</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>Address</span><span class="token punctuation">;</span>

<span class="token class-name static-context">Route</span><span class="token operator">::</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/addresses/{id}&#39;</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$id</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">AddressResource</span><span class="token punctuation">(</span><span class="token class-name static-context">Address</span><span class="token operator">::</span><span class="token function">findOrFail</span><span class="token punctuation">(</span><span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>The resulting JSON output will be something similar to this:</p><div class="language-json line-numbers-mode" data-ext="json"><pre class="language-json"><code><span class="token punctuation">{</span>
    <span class="token property">&quot;data&quot;</span><span class="token operator">:</span> <span class="token punctuation">{</span>
        <span class="token property">&quot;id&quot;</span><span class="token operator">:</span> <span class="token number">5</span><span class="token punctuation">,</span>
        <span class="token property">&quot;street&quot;</span><span class="token operator">:</span> <span class="token string">&quot;24924 Macey Hill Suite 432&quot;</span><span class="token punctuation">,</span>
        <span class="token property">&quot;postal_code&quot;</span><span class="token operator">:</span> <span class="token string">&quot;17092&quot;</span><span class="token punctuation">,</span>
        <span class="token property">&quot;city&quot;</span><span class="token operator">:</span> <span class="token string">&quot;South Eric&quot;</span>
    <span class="token punctuation">}</span><span class="token punctuation">,</span>
    <span class="token property">&quot;meta&quot;</span><span class="token operator">:</span> <span class="token punctuation">{</span>
        <span class="token property">&quot;type&quot;</span><span class="token operator">:</span> <span class="token string">&quot;address&quot;</span><span class="token punctuation">,</span>
        <span class="token property">&quot;self&quot;</span><span class="token operator">:</span> <span class="token string">&quot;http://localhost/addresses/5&quot;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,6);function _(q,w){const e=p("ExternalLinkIcon"),t=p("RouterLink");return l(),r("div",null,[d,n("blockquote",null,[n("p",null,[s('"'),k,s('" ('),n("a",v,[s("source Laravel docs."),a(e)]),s(")")])]),n("p",null,[s("The "),m,s(" is an extended / adapted version of Laravel's "),n("a",b,[g,a(e)]),s('. It ensures that each Api Resource that you create has a "type" and a "self" link. Additionally, all of your Api Resources are registered in a '),a(t,{to:"/archive/v6x/http/api/resources/registrar.html"},{default:o(()=>[s("Registrar")]),_:1}),s(".")]),h,n("p",null,[s("Once you have created your Api Resource, you must register it in the "),a(t,{to:"/archive/v6x/http/api/resources/registrar.html"},{default:o(()=>[s("Registrar")]),_:1}),s(". The easiest way of doing so, is by defining a new key-value pair inside your "),y,s(" configuration file.")]),f])}const R=i(u,[["render",_],["__file","index.html.vue"]]);export{R as default};
