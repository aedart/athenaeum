import{_ as n,p as s,q as a,a1 as e}from"./framework-efe98465.js";const t={},o=e(`<h1 id="protocol-version" tabindex="-1"><a class="header-anchor" href="#protocol-version" aria-hidden="true">#</a> Protocol Version</h1><p>By default, Http protocol version <code>1.1</code> is used for each of your requests. Should you need to send a request with a different version, then <code>useProtocolVersion()</code> will allow you to do so.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$builder</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">useProtocolVersion</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;1.0&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="via-configuration" tabindex="-1"><a class="header-anchor" href="#via-configuration" aria-hidden="true">#</a> Via Configuration</h2><p>The protocol version number can also be set via <code>config/http-clients.php</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token string single-quoted-string">&#39;profiles&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;default&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Drivers<span class="token punctuation">\\</span>DefaultHttpClient</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                
                <span class="token string single-quoted-string">&#39;version&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;1.0&#39;</span>

                <span class="token comment">// ... remaining not shown ...</span>
            <span class="token punctuation">]</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,6),i=[o];function p(l,c){return s(),a("div",null,i)}const u=n(t,[["render",p],["__file","protocol_version.html.vue"]]);export{u as default};
