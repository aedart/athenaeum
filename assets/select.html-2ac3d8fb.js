import{_ as c,M as i,p as d,q as r,R as s,t as e,N as a,U as n,a1 as o}from"./framework-efe98465.js";const p={},u=s("h1",{id:"select",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#select","aria-hidden":"true"},"#"),e(" Select")],-1),m={class:"table-of-contents"},g=o(`<h2 id="select-a-single-field" tabindex="-1"><a class="header-anchor" href="#select-a-single-field" aria-hidden="true">#</a> Select a Single Field</h2><p>The <code>select()</code> method allows you to specify what field(s) should be returned.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">select</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;name&#39;</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><details class="custom-container details"><summary>default</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?select=name
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>json api</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?fields[]=name
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>odata</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?$select=name
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><h2 id="select-field-from-resource" tabindex="-1"><a class="header-anchor" href="#select-field-from-resource" aria-hidden="true">#</a> Select Field from Resource</h2><p>You may also specify what resource the given field should be selected from.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">select</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;name&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;friends&#39;</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><details class="custom-container details"><summary>default</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?select=friends.name
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>json api</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?fields[friends]=name
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>odata</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?$select=friends.name
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><h2 id="select-multiple-fields" tabindex="-1"><a class="header-anchor" href="#select-multiple-fields" aria-hidden="true">#</a> Select Multiple Fields</h2><p>To select multiple fields, you can state an array as argument.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">select</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;friends&#39;</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;age&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;friends&#39;</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;job_title&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;position&#39;</span>
        <span class="token punctuation">]</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><details class="custom-container details"><summary>default</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?select=friends.name,friends.age,position.job_title
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>json api</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?fields[friends]=name,age&amp;fields[position]=job_title
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>odata</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?$select=friends.name,friends.age,position.job_title
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><h2 id="select-raw-expression" tabindex="-1"><a class="header-anchor" href="#select-raw-expression" aria-hidden="true">#</a> Select Raw Expression</h2><p>To perform a raw selection, use the <code>selectRaw()</code> method. It accepts a string expression and an optional bindings array.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">selectRaw</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;account(:number)&#39;</span><span class="token punctuation">,</span> <span class="token punctuation">[</span> <span class="token string single-quoted-string">&#39;number&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">7</span> <span class="token punctuation">]</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><details class="custom-container details"><summary>default</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?select=account(7)
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>json api</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?fields[]=account(7)
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>odata</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?$select=account(7)
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details>`,24);function v(h,b){const l=i("RouterLink"),t=i("router-link");return d(),r("div",null,[u,s("p",null,[e('Provided that the API you are working with supports such, you may select the "fields" to be returned by a response. Typically, you would combine a selection of fields with '),a(l,{to:"/archive/v8x/http/clients/query/include.html"},{default:n(()=>[e("include")]),_:1}),e(".")]),s("nav",m,[s("ul",null,[s("li",null,[a(t,{to:"#select-a-single-field"},{default:n(()=>[e("Select a Single Field")]),_:1})]),s("li",null,[a(t,{to:"#select-field-from-resource"},{default:n(()=>[e("Select Field from Resource")]),_:1})]),s("li",null,[a(t,{to:"#select-multiple-fields"},{default:n(()=>[e("Select Multiple Fields")]),_:1})]),s("li",null,[a(t,{to:"#select-raw-expression"},{default:n(()=>[e("Select Raw Expression")]),_:1})])])]),g])}const f=c(p,[["render",v],["__file","select.html.vue"]]);export{f as default};
