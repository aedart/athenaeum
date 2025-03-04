import{_ as t,M as i,p,q as l,R as s,t as a,N as o,a1 as e}from"./framework-efe98465.js";const d={},r=e(`<h1 id="pagination" tabindex="-1"><a class="header-anchor" href="#pagination" aria-hidden="true">#</a> Pagination</h1><p>Two approaches are offered to set pagination. A cursor-based and a page-based approach.</p><h2 id="limit-offset" tabindex="-1"><a class="header-anchor" href="#limit-offset" aria-hidden="true">#</a> Limit &amp; Offset</h2><p><code>limit()</code> and <code>offset()</code> allow you to limit your results, via a traditional cursor-based pagination.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">limit</span><span class="token punctuation">(</span><span class="token number">10</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">offset</span><span class="token punctuation">(</span><span class="token number">5</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><details class="custom-container details"><summary>default</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?limit=10&amp;offset=5
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>json api</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?page[limit]=10&amp;page[offset]=5
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>odata</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?$top=10&amp;$skip=5
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><h3 id="take-skip" tabindex="-1"><a class="header-anchor" href="#take-skip" aria-hidden="true">#</a> Take &amp; Skip</h3>`,9),c=s("code",null,"take()",-1),u=s("code",null,"skip()",-1),m=s("code",null,"limit()",-1),v=s("code",null,"offset()",-1),g={href:"https://laravel.com/docs/7.x/queries#ordering-grouping-limit-and-offset",target:"_blank",rel:"noopener noreferrer"},h=e(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">take</span><span class="token punctuation">(</span><span class="token number">10</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">skip</span><span class="token punctuation">(</span><span class="token number">5</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><details class="custom-container details"><summary>default</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?limit=10&amp;offset=5
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>json api</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?page[limit]=10&amp;page[offset]=5
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>odata</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?$top=10&amp;$skip=5
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><h2 id="page-show" tabindex="-1"><a class="header-anchor" href="#page-show" aria-hidden="true">#</a> Page &amp; Show</h2><p>If supported by the target API, you can use the page-based pagination methods instead.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">page</span><span class="token punctuation">(</span><span class="token number">3</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">show</span><span class="token punctuation">(</span><span class="token number">25</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><details class="custom-container details"><summary>default</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?page=3&amp;show=25
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>json api</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?page[number]=3&amp;page[size]=25
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>odata</summary><p><strong>Warning</strong>: <em>Page-based pagination is not supported by OData</em></p><div class="language-text line-numbers-mode" data-ext="text"><pre class="language-text"><code>/users
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details>`,10);function k(b,f){const n=i("ExternalLinkIcon");return p(),l("div",null,[r,s("p",null,[c,a(" and "),u,a(" are aliases for "),m,a(" and "),v,a(". These have been added for the sake of convenience and are inspired by Laravel's "),s("a",g,[a("Query Builder"),o(n)]),a(".")]),h])}const x=t(d,[["render",k],["__file","pagination.html.vue"]]);export{x as default};
