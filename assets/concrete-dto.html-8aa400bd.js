import{_ as n,p as s,q as a,a1 as e}from"./framework-efe98465.js";const t={},p=e(`<h1 id="implement-dto" tabindex="-1"><a class="header-anchor" href="#implement-dto" aria-hidden="true">#</a> Implement DTO</h1><p>In order to implement the DTO, extend the <code>Dto</code> abstraction and inherit from your DTO interface (<em>if you choose to use interfaces for your DTOs</em>).</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code>
<span class="token keyword">use</span> <span class="token package">Acme<span class="token punctuation">\\</span>Person</span> <span class="token keyword">as</span> PersonInterface<span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Dto<span class="token punctuation">\\</span>Dto</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">Person</span> <span class="token keyword">extends</span> <span class="token class-name">Dto</span> <span class="token keyword">implements</span> <span class="token class-name">PersonInterface</span>
<span class="token punctuation">{</span>
    <span class="token keyword">protected</span> <span class="token operator">?</span><span class="token keyword type-hint">string</span> <span class="token variable">$name</span> <span class="token operator">=</span> <span class="token string single-quoted-string">&#39;&#39;</span><span class="token punctuation">;</span>
    
    <span class="token keyword">protected</span> <span class="token operator">?</span><span class="token keyword type-hint">int</span> <span class="token variable">$age</span> <span class="token operator">=</span> <span class="token number">0</span><span class="token punctuation">;</span>
 
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">setName</span><span class="token punctuation">(</span><span class="token operator">?</span><span class="token keyword type-hint">string</span> <span class="token variable">$name</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">name</span> <span class="token operator">=</span> <span class="token variable">$name</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">getName</span><span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">:</span> <span class="token operator">?</span><span class="token keyword return-type">string</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">name</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">setAge</span><span class="token punctuation">(</span><span class="token operator">?</span><span class="token keyword type-hint">int</span> <span class="token variable">$age</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">age</span> <span class="token operator">=</span> <span class="token variable">$age</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">getAge</span><span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">:</span> <span class="token operator">?</span><span class="token keyword return-type">int</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">age</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>Now you are ready to use the DTO. The upcoming sections will highlight some of the usage scenarios.</p>`,4),o=[p];function c(i,l){return s(),a("div",null,o)}const u=n(t,[["render",c],["__file","concrete-dto.html.vue"]]);export{u as default};
