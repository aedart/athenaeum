import{_ as s,p as a,q as n,a1 as e}from"./framework-efe98465.js";const t={},i=e(`<h1 id="sorting" tabindex="-1"><a class="header-anchor" href="#sorting" aria-hidden="true">#</a> Sorting</h1><p>In order to request results to be sorted, you can use the <code>orderBy()</code> method. It accepts two arguments:</p><ul><li><code>$field</code>: <code>string|array</code> Name of field or key-value pair, where key = field, value = sorting order.</li><li><code>$direction</code>: <code>string</code> (<em>optional</em>) sorting order, e.g. <code>asc</code> or <code>desc</code>.</li></ul><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
    <span class="token operator">-&gt;</span><span class="token function">orderBy</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;name&#39;</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">orderBy</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;age&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;desc&#39;</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><details class="custom-container details"><summary>default</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?sort=name asc,age desc
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>json api</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?sort=name,-age
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>odata</summary><div class="language-text line-numbers-mode" data-ext="text"><pre class="language-text"><code>/users?$orderby=name asc,age desc
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><h2 id="via-array" tabindex="-1"><a class="header-anchor" href="#via-array" aria-hidden="true">#</a> Via Array</h2><p>You can also use an array as argument. When doing so, the second argument is ignored.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
    <span class="token operator">-&gt;</span><span class="token function">orderBy</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
        <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;desc&#39;</span><span class="token punctuation">,</span>
        <span class="token string single-quoted-string">&#39;age&#39;</span><span class="token punctuation">,</span>
        <span class="token string single-quoted-string">&#39;jobs&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;asc&#39;</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><details class="custom-container details"><summary>default</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?sort=name desc,age asc,jobs asc
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>json api</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?sort=-name,age,jobs
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>odata</summary><div class="language-text line-numbers-mode" data-ext="text"><pre class="language-text"><code>/users?$orderby=name desc,age asc,jobs asc
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details>`,13),o=[i];function r(d,l){return a(),n("div",null,o)}const p=s(t,[["render",r],["__file","sorting.html.vue"]]);export{p as default};
