import{_ as n,p as s,q as a,a1 as e}from"./framework-efe98465.js";const t={},p=e(`<h1 id="custom-default" tabindex="-1"><a class="header-anchor" href="#custom-default" aria-hidden="true">#</a> Custom Default</h1><p>To overwrite the default resolved instance, overwrite the <code>getDefault[Dependency]</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Support<span class="token punctuation">\\</span>Helpers<span class="token punctuation">\\</span>Config<span class="token punctuation">\\</span>ConfigTrait</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Config<span class="token punctuation">\\</span>Repository</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Config<span class="token punctuation">\\</span>Repository</span> <span class="token keyword">as</span> Config<span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">Box</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">ConfigTrait</span><span class="token punctuation">;</span>
    
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">getDefaultConfig</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token operator">?</span><span class="token class-name return-type">Repository</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">Config</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;width&#39;</span>     <span class="token operator">=&gt;</span> <span class="token number">25</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;height&#39;</span>    <span class="token operator">=&gt;</span> <span class="token number">25</span>
        <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
    
    <span class="token comment">// ... remaining not shown ... //</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,3),o=[p];function c(i,l){return s(),a("div",null,o)}const d=n(t,[["render",c],["__file","default.html.vue"]]);export{d as default};
