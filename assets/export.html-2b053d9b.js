import{_ as e,M as t,p as o,q as p,R as n,t as a,N as c,U as r,a1 as i}from"./framework-efe98465.js";const l={},u=n("h1",{id:"export",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#export","aria-hidden":"true"},"#"),a(" Export")],-1),d=n("code",null,"Dto",-1),k=i(`<h2 id="array" tabindex="-1"><a class="header-anchor" href="#array" aria-hidden="true">#</a> Array</h2><p>Each DTO can be exported to an array.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$properties</span> <span class="token operator">=</span> <span class="token variable">$person</span><span class="token operator">-&gt;</span><span class="token function">toArray</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token function">var_dump</span><span class="token punctuation">(</span><span class="token variable">$properties</span><span class="token punctuation">)</span><span class="token punctuation">;</span>  
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div></div></div><p>The above example will output the following:</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>array<span class="token punctuation">(</span><span class="token number">2</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
  <span class="token punctuation">[</span><span class="token string">&quot;name&quot;</span><span class="token punctuation">]</span><span class="token operator">=</span><span class="token operator">&gt;</span> string<span class="token punctuation">(</span><span class="token number">5</span><span class="token punctuation">)</span> <span class="token string">&quot;Timmy&quot;</span>
  <span class="token punctuation">[</span><span class="token string">&quot;age&quot;</span><span class="token punctuation">]</span><span class="token operator">=</span><span class="token operator">&gt;</span> int<span class="token punctuation">(</span><span class="token number">19</span><span class="token punctuation">)</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,5);function h(m,v){const s=t("RouterLink");return o(),p("div",null,[u,n("p",null,[a("The "),d,a(" abstraction supports two main data export methods; to array and "),c(s,{to:"/archive/v8x/dto/json.html"},{default:r(()=>[a("JSON")]),_:1}),a(".")]),k])}const _=e(l,[["render",h],["__file","export.html.vue"]]);export{_ as default};
