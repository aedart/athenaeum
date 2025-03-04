import{_ as t,M as p,p as i,q as c,R as s,t as n,N as o,a1 as a}from"./framework-efe98465.js";const l={},r=a(`<h1 id="usage" tabindex="-1"><a class="header-anchor" href="#usage" aria-hidden="true">#</a> Usage</h1><p>There are two DTOs that you can choose from; <code>Cookie</code> and <code>SetCookie</code>.</p><h2 id="cookie" tabindex="-1"><a class="header-anchor" href="#cookie" aria-hidden="true">#</a> Cookie</h2><p>The <code>Cookie</code> object only contains a <code>name</code> and <code>value</code> property.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Cookies<span class="token punctuation">\\</span>Cookie</span><span class="token punctuation">;</span>

<span class="token variable">$cookie</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">Cookie</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
    <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;my_cookie&#39;</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;value&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;sweet&#39;</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,5),d={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cookie",target:"_blank",rel:"noopener noreferrer"},u=s("code",null,"Cookie",-1),k=a(`<h2 id="set-cookie" tabindex="-1"><a class="header-anchor" href="#set-cookie" aria-hidden="true">#</a> Set-Cookie</h2><p>The <code>SetCookie</code> is an extended version of the <code>Cookie</code> DTO. It offers the following properties</p><ul><li><code>name</code>: Cookie name</li><li><code>value</code>: Cookie value</li><li><code>expires</code>: Maximum lifetime of the cookie</li><li><code>maxAge</code>: Number of seconds until the cookie expires.</li><li><code>domain</code>: Hosts to where the cookie will be sent</li><li><code>path</code>: Path that must exist on the requested url</li><li><code>secure</code>: State of whether the cookie should be sent via https</li><li><code>httpOnly</code>: Whether or not accessing the cookie is forbidden via JavaScript.</li><li><code>sameSite</code>: whether cookie should be available for cross-site requests</li></ul><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Cookies<span class="token punctuation">\\</span>SetCookie</span><span class="token punctuation">;</span>

<span class="token variable">$cookie</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">SetCookie</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
    <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;my_cookie&#39;</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;value&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;sweet&#39;</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;expires&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant">null</span><span class="token punctuation">,</span> <span class="token comment">// null, timestamp or RFC7231 Formatted string date </span>
    <span class="token string single-quoted-string">&#39;maxAge&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">60</span> <span class="token operator">*</span> <span class="token number">5</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;domain&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant">null</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;path&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;/&#39;</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;secure&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant boolean">true</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;httpOnly&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant boolean">false</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;sameSite&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">SetCookie</span><span class="token operator">::</span><span class="token constant">SAME_SITE_LAX</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,4),h={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie",target:"_blank",rel:"noopener noreferrer"},g=s("code",null,"SetCookie",-1),m=a(`<h2 id="populate" tabindex="-1"><a class="header-anchor" href="#populate" aria-hidden="true">#</a> Populate</h2><p>The Cookie DTOs can be populated from an array, via the <code>popualte()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$cookie</span><span class="token operator">-&gt;</span><span class="token function">populate</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
    <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;my_other_cookie&#39;</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$cookie</span><span class="token operator">-&gt;</span><span class="token function">getName</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// &quot;my_other_cookie&quot;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="export-to-array" tabindex="-1"><a class="header-anchor" href="#export-to-array" aria-hidden="true">#</a> Export to Array</h2><p>Both DTOs are able to export their properties to an array, via the <code>toArray()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$data</span> <span class="token operator">=</span> <span class="token variable">$cookie</span><span class="token operator">-&gt;</span><span class="token function">toArray</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="onward" tabindex="-1"><a class="header-anchor" href="#onward" aria-hidden="true">#</a> Onward</h2><p>Please review the source code of these DTOs, for additional information. Feel free to extend these components and offer more functionality, should your application require such.</p>`,8);function v(b,f){const e=p("ExternalLinkIcon");return i(),c("div",null,[r,s("p",null,[n("See "),s("a",d,[n("mozilla.org"),o(e)]),n(" for additional information about what the "),u,n(" DTO is intended to represent.")]),k,s("p",null,[n("See "),s("a",h,[n("mozilla.org"),o(e)]),n(" for additional information about what the "),g,n(" DTO is intended to represent.")]),m])}const x=t(l,[["render",v],["__file","usage.html.vue"]]);export{x as default};
