import{_ as l,M as c,p as i,q as r,R as n,N as a,U as t,t as s,a1 as p}from"./framework-efe98465.js";const u={},d=n("h1",{id:"misc",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#misc","aria-hidden":"true"},"#"),s(" Misc")],-1),k={class:"table-of-contents"},m=n("h2",{id:"id",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#id","aria-hidden":"true"},"#"),s(" Id")],-1),h=n("code",null,"id()",-1),g={href:"https://www.php.net/manual/en/function.get-resource-id",target:"_blank",rel:"noopener noreferrer"},v=n("code",null,"get_resource_id()",-1),b=p(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$stream</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;pets.txt&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;r&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$stream</span><span class="token operator">-&gt;</span><span class="token function">id</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// 1330</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="mode" tabindex="-1"><a class="header-anchor" href="#mode" aria-hidden="true">#</a> Mode</h2><p>The stream&#39;s mode can be determined via the <code>mode()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$stream</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;bills.txt&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;w+b&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$stream</span><span class="token operator">-&gt;</span><span class="token function">mode</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// w+b</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,4),_={href:"https://www.php.net/manual/en/function.stream-get-meta-data",target:"_blank",rel:"noopener noreferrer"},f=n("code",null,"stream_get_meta_data()",-1),w=p(`<h2 id="uri" tabindex="-1"><a class="header-anchor" href="#uri" aria-hidden="true">#</a> Uri</h2><p>The stream&#39;s filename or URI can be obtained using <code>uri()</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$stream</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;https://example.com/books&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;r+b&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$stream</span><span class="token operator">-&gt;</span><span class="token function">uri</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// https://example.com/books</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,3),x={href:"https://www.php.net/manual/en/function.stream-get-meta-data",target:"_blank",rel:"noopener noreferrer"},y=n("code",null,"stream_get_meta_data()",-1),q=p(`<h2 id="type" tabindex="-1"><a class="header-anchor" href="#type" aria-hidden="true">#</a> Type</h2><h3 id="resource-type" tabindex="-1"><a class="header-anchor" href="#resource-type" aria-hidden="true">#</a> Resource Type</h3><p>To determine the type of the underlying resource, use the <code>type()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$stream</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;pets.txt&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;r&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$stream</span><span class="token operator">-&gt;</span><span class="token function">type</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// stream</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,4),S={href:"https://www.php.net/manual/en/function.get-resource-type",target:"_blank",rel:"noopener noreferrer"},T=n("code",null,"get_resource_type()",-1),$=p(`<h3 id="stream-type" tabindex="-1"><a class="header-anchor" href="#stream-type" aria-hidden="true">#</a> Stream Type</h3><p>To determine the stream type, use <code>streamType()</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$stream</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;pets.txt&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;r&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$stream</span><span class="token operator">-&gt;</span><span class="token function">streamType</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// STDIO</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,3),F={href:"https://www.php.net/manual/en/function.stream-get-meta-data",target:"_blank",rel:"noopener noreferrer"},R=n("code",null,"stream_get_meta_data()",-1),B=p(`<h3 id="stream-wrapper-type" tabindex="-1"><a class="header-anchor" href="#stream-wrapper-type" aria-hidden="true">#</a> Stream Wrapper Type</h3><p>The stream&#39;s wrapper type can be determined via <code>wrapperType()</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$stream</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;pets.txt&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;r&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$stream</span><span class="token operator">-&gt;</span><span class="token function">wrapperType</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// plainfile</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,3),I={href:"https://www.php.net/manual/en/function.stream-get-meta-data",target:"_blank",rel:"noopener noreferrer"},L=n("code",null,"stream_get_meta_data()",-1),M=p(`<h2 id="wrapper-data" tabindex="-1"><a class="header-anchor" href="#wrapper-data" aria-hidden="true">#</a> Wrapper Data</h2><p><code>wrapperData()</code> can be used for obtaining stream wrapper&#39;s data.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$stream</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;https://www.google.com&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;r&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$stream</span><span class="token operator">-&gt;</span><span class="token function">wrapperData</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// ...not shown here...</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,3),D={href:"https://www.php.net/manual/en/function.stream-get-meta-data",target:"_blank",rel:"noopener noreferrer"},N=n("code",null,"stream_get_meta_data()",-1),O=p(`<h2 id="blocking-mode" tabindex="-1"><a class="header-anchor" href="#blocking-mode" aria-hidden="true">#</a> Blocking Mode</h2><p>To set the stream&#39;s blocking mode, use <code>setBlocking()</code>. Furthermore, use <code>blocked()</code> to determine if the stream is blocked.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$stream</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;houses.txt&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;r+b&#39;</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">setBlocking</span><span class="token punctuation">(</span><span class="token constant boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$stream</span><span class="token operator">-&gt;</span><span class="token function">blocked</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// true</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,3),P={href:"https://www.php.net/manual/en/function.stream-set-blocking.php",target:"_blank",rel:"noopener noreferrer"},U=p(`<h2 id="timeout" tabindex="-1"><a class="header-anchor" href="#timeout" aria-hidden="true">#</a> Timeout</h2><p>The <code>setTimeout()</code> can be used to set the stream&#39;s timeout, whereas the <code>timedOut()</code> can be used to determine if a stream has timed out.</p><p>It accepts two arguments:</p><ul><li><code>int $seconds</code>: Seconds part of the timeout to be set.</li><li><code>int $microseconds</code>: (<em>optional</em>) microseconds part of the timeout to be set.</li></ul><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$stream</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;houses.txt&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;r+b&#39;</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">setTimeout</span><span class="token punctuation">(</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">50</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$stream</span><span class="token operator">-&gt;</span><span class="token function">timedOut</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// false</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,5),V={href:"https://www.php.net/manual/en/function.stream-set-timeout",target:"_blank",rel:"noopener noreferrer"},W=n("code",null,"stream_set_timeout()",-1),E=p(`<h2 id="local-or-remote" tabindex="-1"><a class="header-anchor" href="#local-or-remote" aria-hidden="true">#</a> Local or Remote</h2><p>To determine if a stream is &quot;local&quot; or &quot;remote&quot;, use the <code>isLocal()</code> and <code>isRemote()</code> methods.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$a</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;https://www.google.com&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;r&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$b</span> <span class="token operator">=</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;books.txt&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;r&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$a</span><span class="token operator">-&gt;</span><span class="token function">isLocal</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// false</span>
<span class="token keyword">echo</span> <span class="token variable">$b</span><span class="token operator">-&gt;</span><span class="token function">isLocal</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// true</span>

<span class="token keyword">echo</span> <span class="token variable">$a</span><span class="token operator">-&gt;</span><span class="token function">isRemote</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// true</span>
<span class="token keyword">echo</span> <span class="token variable">$b</span><span class="token operator">-&gt;</span><span class="token function">isRemote</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// false</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,3),C={href:"https://www.php.net/manual/en/function.stream-is-local.php",target:"_blank",rel:"noopener noreferrer"},H=n("code",null,"stream_is_local()",-1),j=n("h2",{id:"onward",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#onward","aria-hidden":"true"},"#"),s(" Onward")],-1),z=n("p",null,"For additional utility methods, please review the source code the provided stream components.",-1);function A(G,J){const e=c("router-link"),o=c("ExternalLinkIcon");return i(),r("div",null,[d,n("nav",k,[n("ul",null,[n("li",null,[a(e,{to:"#id"},{default:t(()=>[s("Id")]),_:1})]),n("li",null,[a(e,{to:"#mode"},{default:t(()=>[s("Mode")]),_:1})]),n("li",null,[a(e,{to:"#uri"},{default:t(()=>[s("Uri")]),_:1})]),n("li",null,[a(e,{to:"#type"},{default:t(()=>[s("Type")]),_:1}),n("ul",null,[n("li",null,[a(e,{to:"#resource-type"},{default:t(()=>[s("Resource Type")]),_:1})]),n("li",null,[a(e,{to:"#stream-type"},{default:t(()=>[s("Stream Type")]),_:1})]),n("li",null,[a(e,{to:"#stream-wrapper-type"},{default:t(()=>[s("Stream Wrapper Type")]),_:1})])])]),n("li",null,[a(e,{to:"#wrapper-data"},{default:t(()=>[s("Wrapper Data")]),_:1})]),n("li",null,[a(e,{to:"#blocking-mode"},{default:t(()=>[s("Blocking Mode")]),_:1})]),n("li",null,[a(e,{to:"#timeout"},{default:t(()=>[s("Timeout")]),_:1})]),n("li",null,[a(e,{to:"#local-or-remote"},{default:t(()=>[s("Local or Remote")]),_:1})]),n("li",null,[a(e,{to:"#onward"},{default:t(()=>[s("Onward")]),_:1})])])]),m,n("p",null,[h,s(" returns an integer id for the stream's underlying resource. See "),n("a",g,[v,a(o)]),s(" for details.")]),b,n("p",null,[s("See "),n("a",_,[f,a(o)]),s(" for details.")]),w,n("p",null,[s("See "),n("a",x,[y,a(o)]),s(" for details.")]),q,n("p",null,[s("See "),n("a",S,[T,a(o)]),s(" for more information.")]),$,n("p",null,[s("See "),n("a",F,[R,a(o)]),s(" for details.")]),B,n("p",null,[s("See "),n("a",I,[L,a(o)]),s(" for details.")]),M,n("p",null,[s("See "),n("a",D,[N,a(o)]),s(" for details.")]),O,n("p",null,[s("See "),n("a",P,[s("PHP's stream blocking mode"),a(o)]),s(" for additional information.")]),U,n("p",null,[s("See "),n("a",V,[W,a(o)]),s(" for more information.")]),E,n("p",null,[s("PHP's "),n("a",C,[H,a(o)]),s(" is used to determine if a stream is local or remote.")]),j,z])}const Q=l(u,[["render",A],["__file","misc.html.vue"]]);export{Q as default};
