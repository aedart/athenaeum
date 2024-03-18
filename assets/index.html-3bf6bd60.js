import{_ as e,M as t,p as o,q as p,R as a,t as n,N as c,a1 as i}from"./framework-efe98465.js";const l={},u=a("h1",{id:"audit",tabindex:"-1"},[a("a",{class:"header-anchor",href:"#audit","aria-hidden":"true"},"#"),n(" Audit")],-1),d={href:"https://en.wikipedia.org/wiki/Audit_trail",target:"_blank",rel:"noopener noreferrer"},r=i(`<h2 id="example" tabindex="-1"><a class="header-anchor" href="#example" aria-hidden="true">#</a> Example</h2><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">namespace</span> <span class="token package">Acme<span class="token punctuation">\\</span>Models</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Database<span class="token punctuation">\\</span>Eloquent<span class="token punctuation">\\</span>Model</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Audit<span class="token punctuation">\\</span>Traits<span class="token punctuation">\\</span>RecordsChanges</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">Category</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">RecordsChanges</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>Later in your application...</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$category</span> <span class="token operator">=</span> <span class="token class-name static-context">Category</span><span class="token operator">::</span><span class="token function">create</span><span class="token punctuation">(</span> <span class="token punctuation">[</span> <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;My category&#39;</span> <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Obtain the &quot;changes&quot; made (in this case a &quot;create&quot; event) </span>
<span class="token variable">$changes</span> <span class="token operator">=</span> <span class="token variable">$category</span><span class="token operator">-&gt;</span><span class="token function">recordedChanges</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">first</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token function">print_r</span><span class="token punctuation">(</span><span class="token variable">$changes</span><span class="token operator">-&gt;</span><span class="token function">toArray</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Example output:</span>
<span class="token comment">//    [</span>
<span class="token comment">//      &quot;id&quot; =&gt; 1</span>
<span class="token comment">//      &quot;user_id&quot; =&gt; null</span>
<span class="token comment">//      &quot;auditable_type&quot; =&gt; &quot;Acme\\Models\\Category&quot;</span>
<span class="token comment">//      &quot;auditable_id&quot; =&gt; &quot;24&quot;</span>
<span class="token comment">//      &quot;type&quot; =&gt; &quot;created&quot;</span>
<span class="token comment">//      &quot;message&quot; =&gt; &quot;Recording created event&quot;</span>
<span class="token comment">//      &quot;original_data&quot; =&gt; null</span>
<span class="token comment">//      &quot;changed_data&quot; =&gt; [</span>
<span class="token comment">//        &quot;name&quot; =&gt; &quot;My Category&quot;</span>
<span class="token comment">//        &quot;id&quot; =&gt; 1</span>
<span class="token comment">//      ]</span>
<span class="token comment">//      &quot;performed_at&quot; =&gt; &quot;2021-04-28T11:07:24.000000Z&quot;</span>
<span class="token comment">//      &quot;created_at&quot; =&gt; &quot;2021-04-28T11:07:24.000000Z&quot;</span>
<span class="token comment">//    ]</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,4);function m(k,v){const s=t("ExternalLinkIcon");return o(),p("div",null,[u,a("p",null,[n("An "),a("a",d,[n("audit trail"),c(s)]),n(' package for Laravel Eloquent Model. It is able to store the changes made on a given model into an "audit trails" table, along with the attributes that have been changed.')]),r])}const b=e(l,[["render",m],["__file","index.html.vue"]]);export{b as default};
