import{_ as o,M as e,p as i,q as l,R as s,t as n,N as a,U as c,a1 as r}from"./framework-efe98465.js";const u={},d=s("h1",{id:"mime-type",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#mime-type","aria-hidden":"true"},"#"),n(" MIME-Type")],-1),m=s("code",null,"mimeType()",-1),k={href:"https://en.wikipedia.org/wiki/Media_type",target:"_blank",rel:"noopener noreferrer"},h=r(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$stream</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;houses.txt&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;rb&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$stream</span><span class="token operator">-&gt;</span><span class="token function">mimeType</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// text/plain</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>Behind the scene, the <a href="./../../mime-types">MIME-Type Component</a> is used.</p><h2 id="profile-and-options" tabindex="-1"><a class="header-anchor" href="#profile-and-options" aria-hidden="true">#</a> Profile and Options</h2><p>The method also allows you to specify what &quot;profile&quot; to use for determining the MIME-Type, as well as eventual options for the profile.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$stream</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;houses.txt&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;rb&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$stream</span><span class="token operator">-&gt;</span><span class="token function">mimeType</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;mime-detector-profile&#39;</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string single-quoted-string">&#39;sample_size&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">50</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// text/plain</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,5);function g(v,f){const t=e("ExternalLinkIcon"),p=e("RouterLink");return i(),l("div",null,[d,s("p",null,[n("The "),m,n(" method can be used to determine the file stream's "),s("a",k,[n("MIME-Type"),a(t)]),n(".")]),h,s("p",null,[n("Please see "),a(p,{to:"/archive/v6x/mime-types/usage.html"},{default:c(()=>[n("MIME-Type usage")]),_:1}),n(" for additional details.")])])}const b=o(u,[["render",g],["__file","mime-type.html.vue"]]);export{b as default};
