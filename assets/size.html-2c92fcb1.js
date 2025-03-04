import{_ as c,M as o,p as l,q as r,R as n,N as a,U as t,t as s,a1 as i}from"./framework-efe98465.js";const d={},u=n("h1",{id:"size",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#size","aria-hidden":"true"},"#"),s(" Size")],-1),m=n("p",null,[s("The "),n("code",null,"Stream"),s(" components offer a few ways to determine the size of the underlying resource.")],-1),h={class:"table-of-contents"},k=i(`<h2 id="raw-size" tabindex="-1"><a class="header-anchor" href="#raw-size" aria-hidden="true">#</a> Raw size</h2><p>Use <code>getSize()</code> to obtain the stream&#39;s size in bytes. The method returns <code>null</code> if the size is not known or cannot be determined.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// E.g. open file that 128 bytes in size</span>
<span class="token variable">$stream</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;persons.txt&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;r&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$stream</span><span class="token operator">-&gt;</span><span class="token function">getSize</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// 128</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="count" tabindex="-1"><a class="header-anchor" href="#count" aria-hidden="true">#</a> Count</h2>`,4),v=n("code",null,"Stream",-1),g={href:"https://www.php.net/manual/en/class.countable",target:"_blank",rel:"noopener noreferrer"},f=n("code",null,"Countable",-1),_=n("code",null,"count()",-1),b=i(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// E.g. open file that 51 bytes in size</span>
<span class="token variable">$stream</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;places.txt&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;r&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token function">count</span><span class="token punctuation">(</span><span class="token variable">$stream</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// 51</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="formatted-size" tabindex="-1"><a class="header-anchor" href="#formatted-size" aria-hidden="true">#</a> Formatted Size</h2><p>Use <code>getFormattedSize()</code> if you wish to obtain a &quot;human-readable&quot; size of the stream.</p><p><em>The method returns a formatted string.</em></p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// E.g. open a &quot;large&quot; file...</span>
<span class="token variable">$stream</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;fx_lightning.mp4&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;r&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$stream</span><span class="token operator">-&gt;</span><span class="token function">getFormattedSize</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// 4.3 MB</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,5);function z(x,w){const e=o("router-link"),p=o("ExternalLinkIcon");return l(),r("div",null,[u,m,n("nav",h,[n("ul",null,[n("li",null,[a(e,{to:"#raw-size"},{default:t(()=>[s("Raw size")]),_:1})]),n("li",null,[a(e,{to:"#count"},{default:t(()=>[s("Count")]),_:1})]),n("li",null,[a(e,{to:"#formatted-size"},{default:t(()=>[s("Formatted Size")]),_:1})])])]),k,n("p",null,[s("The "),v,s(" components inherit from "),n("a",g,[s("PHP's "),f,s(" interface"),a(p)]),s(". This allows you to use "),_,s(" directly on the stream.")]),b])}const q=c(d,[["render",z],["__file","size.html.vue"]]);export{q as default};
