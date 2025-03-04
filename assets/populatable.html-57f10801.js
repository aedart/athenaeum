import{_ as t,M as o,p,q as i,R as n,t as a,N as e,a1 as l}from"./framework-efe98465.js";const c={},r=n("h1",{id:"populatable",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#populatable","aria-hidden":"true"},"#"),a(" Populatable")],-1),u={href:"https://en.wikipedia.org/wiki/Data_transfer_object",target:"_blank",rel:"noopener noreferrer"},d=n("code",null,"Populatable",-1),k=n("code",null,"populate()",-1),v=l(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Utils<span class="token punctuation">\\</span>Populatable</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">Box</span> <span class="token keyword">implements</span> <span class="token class-name">Populatable</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">populate</span><span class="token punctuation">(</span><span class="token keyword type-hint">array</span> <span class="token variable">$data</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token punctuation">]</span><span class="token punctuation">)</span> <span class="token punctuation">:</span> <span class="token keyword return-type">static</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">foreach</span><span class="token punctuation">(</span><span class="token variable">$data</span> <span class="token keyword">as</span> <span class="token variable">$name</span> <span class="token operator">=&gt;</span> <span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">{</span>
            <span class="token comment">// Populate your object... not shown here</span>
        <span class="token punctuation">}</span>
        
        <span class="token keyword">return</span> <span class="token variable">$this</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="verify-required-properties" tabindex="-1"><a class="header-anchor" href="#verify-required-properties" aria-hidden="true">#</a> Verify Required Properties</h2><p>A quick way to ensure that your objects are populated with the correct properties, is by using the <code>verifyRequired()</code> method, via the <code>PopulateHelper</code>. It will automatically throw an <code>\\Exception</code>, in case that a required property is missing.</p><p>State the name of the required properties, as the 2nd argument for the <code>verifyRequired()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Utils<span class="token punctuation">\\</span>Populatable</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Utils<span class="token punctuation">\\</span>Helpers<span class="token punctuation">\\</span>PopulateHelper</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">Box</span> <span class="token keyword">implements</span> <span class="token class-name">Populatable</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">populate</span><span class="token punctuation">(</span><span class="token keyword type-hint">array</span> <span class="token variable">$data</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token punctuation">]</span><span class="token punctuation">)</span> <span class="token punctuation">:</span> <span class="token keyword return-type">static</span>
    <span class="token punctuation">{</span>
        <span class="token comment">// Fail if &quot;width&quot; and &quot;height&quot; properties are missing</span>
        <span class="token class-name static-context">PopulateHelper</span><span class="token operator">::</span><span class="token function">verifyRequired</span><span class="token punctuation">(</span><span class="token variable">$data</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;width&#39;</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;height&#39;</span>
        <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        
        <span class="token comment">// ...Do something with data...</span>
        
        <span class="token keyword">return</span> <span class="token variable">$this</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,5),m={class:"custom-container warning"},h=n("p",{class:"custom-container-title"},"WARNING",-1),b=n("code",null,"verifyRequired()",-1),y={href:"https://laravel.com/docs/11.x/validation#validating-arrays",target:"_blank",rel:"noopener noreferrer"};function f(_,g){const s=o("ExternalLinkIcon");return p(),i("div",null,[r,n("p",null,[a("Should you require a uniform way to populate (hydrate) your objects, e.g. a model or a "),n("a",u,[a("dto"),e(s)]),a(", then the "),d,a(" interface is a good way to go. The "),k,a(" method allows you to hydrate your object using an array.")]),v,n("div",m,[h,n("p",null,[b,a(" is not intended to be a saturated validation method for input. Please consider using a "),n("a",y,[a("Validator"),e(s)]),a(", if you plan to populate objects with data received from a request or other untrusted source.")])])])}const q=t(c,[["render",f],["__file","populatable.html.vue"]]);export{q as default};
