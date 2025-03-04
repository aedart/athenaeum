import{_ as n,p as a,q as s,a1 as e}from"./framework-efe98465.js";const t={},o=e(`<h1 id="instantiatable" tabindex="-1"><a class="header-anchor" href="#instantiatable" aria-hidden="true">#</a> Instantiatable</h1><p>Models that inherit from the <code>Instantiatable</code> interface, allow creating new instances statically and accept a database connection, via the <code>make()</code> method. The <code>Instance</code> concern trait offers a default implementation.</p><h2 id="how-to-use" tabindex="-1"><a class="header-anchor" href="#how-to-use" aria-hidden="true">#</a> How to use</h2><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Database<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>Instantiatable</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Database<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>Concerns</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Database<span class="token punctuation">\\</span>Eloquent<span class="token punctuation">\\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">Post</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span> <span class="token keyword">implements</span> <span class="token class-name">Instantiatable</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">Concerns<span class="token punctuation">\\</span>Instance</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>

<span class="token comment">// ... later in your application</span>
<span class="token variable">$post</span> <span class="token operator">=</span> <span class="token class-name static-context">Post</span><span class="token operator">::</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// Creates a new instance</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="attributes" tabindex="-1"><a class="header-anchor" href="#attributes" aria-hidden="true">#</a> Attributes</h2><p>The <code>make()</code> method accepts an array of attributes.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$post</span> <span class="token operator">=</span> <span class="token class-name static-context">Post</span><span class="token operator">::</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
    <span class="token string single-quoted-string">&#39;author&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Christina Stein&#39;</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;content&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;When one avoids totality and attitude, one is able to hurt harmony.&#39;</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="connection" tabindex="-1"><a class="header-anchor" href="#connection" aria-hidden="true">#</a> Connection</h2><p>Lastly, you may also specify which connection should be used by the model.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$post</span> <span class="token operator">=</span> <span class="token class-name static-context">Post</span><span class="token operator">::</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token punctuation">[</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;my-db-connection&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div>`,10),p=[o];function c(i,l){return a(),s("div",null,p)}const d=n(t,[["render",c],["__file","instantiatable.html.vue"]]);export{d as default};
